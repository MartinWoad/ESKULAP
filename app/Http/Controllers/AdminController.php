<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use DOMDocument;
use DOMXPath;

use DB;
use URL;

class AdminController extends Controller
{

    public function formularzRejestracji()
    {
        $lekarze = User::where('funkcja', User::LEKARZ)->get();

        $is_admin = session()->get(User::ADMIN) === 'true';
        if (!$is_admin) {
            header("Location: " . URL::to('/'));
            return;
        }

        return view('admin.rejestracja', compact('lekarze'));
    }

	public function zarejestruj( Request $request )
	{

		function hasLetters($string)
		{
			if (preg_match('/[A-Za-z]/', $string))
			{
			    return true;
			}
			return false;
		}

		function hasNumbers($string)
		{
			if(1 === preg_match('~[0-9]~', $string)){
    		return true;
			}
			return false;
		}

		function CheckPESEL($str)
		{
			if (!preg_match('/^[0-9]{11}$/',$str)) //sprawdzamy czy ciąg ma 11 cyfr
			{
				return false;
			}
		 
			$arrSteps = array(1, 3, 7, 9, 1, 3, 7, 9, 1, 3); // tablica z odpowiednimi wagami
			$intSum = 0;
			for ($i = 0; $i < 10; $i++)
			{
				$intSum += $arrSteps[$i] * $str[$i]; //mnożymy każdy ze znaków przez wagę i sumujemy wszystko
			}
			$int = 10 - $intSum % 10; //obliczamy sumć kontrolną
			$intControlNr = ($int == 10)?0:$int;
			if ($intControlNr == $str[10]) //sprawdzamy czy taka sama suma kontrolna jest w ciągu
			{
				return true;
			}
			return false;
		}

		if(DB::table('users')->where('login', $request->input("username"))->first() != "")
		{
			return redirect()->back()->with('error', 'Wybrany login jest zajęty!');
		}

		$funkcja 		= $request->input('funkcja');	
		$imie           = $request->input('forename');
		$nazwisko       = $request->input('surname');
		$data_urodzenia = $request->input('dateOfBirth');
		$pesel          = $request->input('pesel');

		if(hasNumbers($imie) || hasNumbers($nazwisko) || strlen($imie) > 16 || strlen($imie) < 3 || strlen($nazwisko) > 16 || strlen($nazwisko) < 3)
		{
			return redirect()->back()->with('error', 'Błąd w imieniu lub nazwisku.');
		}

		$rok 	 = substr($data_urodzenia, 0, 4);
		$miesiac = substr($data_urodzenia, 5, 2);
		$dzien   = substr($data_urodzenia, 8, 2);
		if(substr($data_urodzenia, 4,1) != "-" || $rok < 1910 || $rok > date("Y") || $miesiac > 12 || $dzien > 31 || $dzien < 1 || $miesiac < 1)
		{
			return redirect()->back()->with('error', 'Błędna data.');
		}

		//Sprawdzenie numeru PESEL
		if(!CheckPESEL($pesel) || strlen($pesel ) != 11 || hasLetters($pesel))
		{
			return redirect()->back()->with('error', 'Błędny numer PESEL.');
		}

		//Porównanie PESELU z datą urodzenia (zaimplementowane sprawdzanie dla daty > 2000)
		$dzien   = substr($pesel, 4, 2);
		$miesiac = substr($pesel, 2, 2);
		$rok     = substr($pesel, 0, 2);

		$dataUrodzeniaDzien = substr($data_urodzenia, 8, 2);
		$dataUrodzeniaMiesiac = substr($data_urodzenia, 5, 2);
		$dataUrodzeniaRok = substr($data_urodzenia, 2, 2);
		if($miesiac > 12) // Jeżeli jest to rocznik >= 2000 (dodajemy do miesiąca 20)
		{
			$dataUrodzeniaMiesiac += 20;
		} 

		if($dataUrodzeniaDzien != $dzien || $dataUrodzeniaMiesiac != $miesiac || $dataUrodzeniaRok != $rok)
		{
			return redirect()->back()->with('error', 'Numer PESEL nie odpowiada wprowadzonym danym.');
		}
		

		switch($funkcja)
		{
			case "lekarz":
			case "ordynator":
				$login          = $request->input('username');
				$haslo          = $request->input('password');
				$potw_haslo     = $request->input('password_confirm');

				if(strlen($login) > 16 || strlen($login) < 5 || strlen($haslo) > 16 || strlen($haslo) < 5 || $haslo != $potw_haslo)
				{
					return redirect()->back()->with('error', 'Błędny login lub hasło.');
				}
				// Póki co
				$ip = "127.0.0.1";
				$hashed = HASH::make($haslo);
				DB::table('users')->insert(
                [
                'login' => $login, 
                'haslo' => $hashed,
                'imie' => $imie,
                'nazwisko' => $nazwisko,
                'pesel' => $pesel,
                'data_ur' => $data_urodzenia,
                'funkcja' => $funkcja,
                'adres_ip' => "127.0.0.1"
                ]);

			break;
			case "pacjent":
				$plec 			= $request->input('gender');
				$id_lekarza     = $request->input('patientsDoctor');
				$file 			= $request->file('image');


				$PESELplec = substr($pesel, 9, 1);
				if(($PESELplec % 2 == 1 && $plec == "Kobieta") || ($PESELplec % 2 == 0) && $plec == "Mężczyzna" )
				{
					return redirect()->back()->with('error', 'Numer PESEL nie odpowiada wprowadzonym danym.');
				}

				if(DB::table('users')->where('id', $id_lekarza)->where('funkcja', 'lekarz')->first() == "")
				{
					return redirect()->back()->with('error', 'Błędne id lekarza.');
				}


				if (!$request->file('image')->isValid()) {
					return redirect()->back()->with('error', "Błąd pliku.");
				}

				if($file->getSize() > 10000000)
				{
					return redirect()->back()->with('error', "Wybrany plik jest zbyt duży.");
				}

				$id = DB::table('patients')->insertGetId(
                [
                'imie' => $imie,
                'nazwisko' => $nazwisko,
                'pesel' => $pesel,
                'plec'  => $plec,
                'data_ur' => $data_urodzenia,
                'id_lekarza' => $id_lekarza
                ]);

				$destinationPath = 'pictures/original';
 			    $fileName = $id.$file->getClientOriginalName();
 			    $file->move($destinationPath,$fileName);

 			    DB::table('photos')->insert(
 			    [
 			    	'directory' => $destinationPath."/".$fileName,
 			    	'data' => date("Y-m-d"),
 			    	'oryginal'  => true,
 			    	'id_pacjenta' => $id
 			    ]);


			break;
			default:
				return redirect()->back()->with('error', 'Nie wybrano właściwej funkcji!');
			break;
		}
		return redirect()->back()->with('success', 'Rejestracja zakończona sukcesem!');
	}





}
