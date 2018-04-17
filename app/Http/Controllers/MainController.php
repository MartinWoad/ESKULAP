<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use DOMDocument;
use DOMXPath;
use Session;

use DB;

class MainController extends Controller
{

	public function getPhotos( Request $request )
	{
		return redirect()->back()->with('photoModal', $request->input('id'));
	}

	public function funkcje( Request $request )
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


		$operacja = $request->input("action");
		$id       = $request->input("id");
		switch($operacja)
		{
			case "delete":
				if($request->input("funkcja") == "patient")
				{
					DB::table('patients')->where('id', $id)->delete();

					if(DB::table('photos')->where('id_pacjenta', $id)->first() != "")
					{
						$photos = DB::table('photos')->where('id_pacjenta', $id)->get();
						foreach($photos as $photo)
						{
							if(DB::table('coloured')->where("original_id", $photo->id)->first() != "")
							{
								unlink(DB::table('coloured')->where("original_id", $photo->id)->first()->directory);
								DB::table('coloured')->where("original_id", $photo->id)->delete();
							}
							unlink($photo->directory);
						}
						DB::table('photos')->where('id_pacjenta', $id)->delete();
					}

					return redirect()->back()->with('message', 'Pacjent został usunięty.');
				} else{
					DB::table('users')->where('id', $id)->delete();
					return redirect()->back()->with('message', 'Użytkownik został usunięty.');
				}
			break;
			case "editPatient":
				$imie 	 	 	  = $request->input("forename");
		        $nazwisko	 	  = $request->input("surname");
		        $plec 			  = $request->input("gender");
		        $dataUrodzenia 	  = $request->input("dateOfBirth");
		        $pesel 		 	  = $request->input("pesel");
		        $lekarz			  = $request->input("patientsDoctor");
		        if(Session::has('user')){
		        if(DB::table('users')->where("id", session()->get('user'))->first()->funkcja == "ordynator")
				{
					return redirect()->back()->with('error', 'To konto nie ma uprawnień do edycji danych pacjentów.');
				}
				}


		        if(hasNumbers($imie) || hasNumbers($nazwisko) || strlen($imie) > 16 || strlen($imie) < 3 || strlen($nazwisko) > 16 || strlen($nazwisko) < 3)
				{
					return redirect()->back()->with('error', 'Błąd w imieniu lub nazwisku.');
				}

				// Sprawdzenie wprowadzonej daty
				$rok 	 = substr($dataUrodzenia, 0, 4);
				$miesiac = substr($dataUrodzenia, 5, 2);
				$dzien   = substr($dataUrodzenia, 8, 2);
				if(substr($dataUrodzenia, 4,1) != "-" || $rok < 1910 || $rok > date("Y") || $miesiac > 12 || $dzien > 31 || $dzien < 1 || $miesiac < 1)
				{
					return redirect()->back()->with('error', 'Błędna data.');
				}

				//Sprawdzenie numeru PESEL
				if(!CheckPESEL($pesel) || strlen($pesel ) != 11 || hasLetters($pesel))
				{
					return redirect()->back()->with('error', 'Błędny numer PESEL.');
				}

				$dzien   = substr($pesel, 4, 2);
				$miesiac = substr($pesel, 2, 2);
				$rok     = substr($pesel, 0, 2);

				$dataUrodzeniaDzien = substr($dataUrodzenia, 8, 2);
				$dataUrodzeniaMiesiac = substr($dataUrodzenia, 5, 2);
				$dataUrodzeniaRok = substr($dataUrodzenia, 2, 2);
				if($miesiac > 12) // Jeżeli jest to rocznik >= 2000 (dodajemy do miesiąca 20)
				{
					$dataUrodzeniaMiesiac += 20;
				}

				if($dataUrodzeniaDzien != $dzien || $dataUrodzeniaMiesiac != $miesiac || $dataUrodzeniaRok != $rok)
				{
					return redirect()->back()->with('error', 'Numer PESEL nie odpowiada wprowadzonym danym.');
				}

				// Sprawdzenie czy płeć zgadza się z PESELem
				$PESELplec = substr($pesel, 9, 1);
				if(($PESELplec % 2 == 1 && $plec == "Kobieta") || ($PESELplec % 2 == 0) && $plec == "Mężczyzna" )
				{
					return redirect()->back()->with('error', 'Numer PESEL nie odpowiada wprowadzonym danym.');
				}

				if($lekarz == "none"){
					$lekarz = "0";
				}
		        DB::table('patients')->where('id', $id)->update([
		        	'imie' => $imie,
		        	'nazwisko' => $nazwisko,
		        	'pesel' => $pesel,
		        	'plec' => $plec,
		        	'data_ur' => $dataUrodzenia,
		        	'id_lekarza' => $lekarz
		        ]);

				return redirect()->back()->with('message', 'Dane pacjenta zostały zaktualizowane.');
			break;
			// Only admin can use this function
			case "editUser":
				$imie 	 	 	  = $request->input("forename");
		        $nazwisko	 	  = $request->input("surname");
		        $dataUrodzenia 	  = $request->input("dateOfBirth");
		        $pesel 		 	  = $request->input("pesel");
		        $login 		 	  = $request->input("login");
		        $password 		  = $request->input("password");
		        $funkcja 		  = $request->input("funkcja");



		        if(hasNumbers($imie) || hasNumbers($nazwisko) || strlen($imie) > 16 || strlen($imie) < 3 || strlen($nazwisko) > 16 || strlen($nazwisko) < 3)
				{
					return redirect()->back()->with('error', 'Błąd w imieniu lub nazwisku.');
				}

				$rok 	 = substr($dataUrodzenia, 0, 4);
				$miesiac = substr($dataUrodzenia, 5, 2);
				$dzien   = substr($dataUrodzenia, 8, 2);
				if(substr($dataUrodzenia, 4,1) != "-" || $rok < 1910 || $rok > date("Y") || $miesiac > 12 || $dzien > 31 || $dzien < 1 || $miesiac < 1)
				{
					return redirect()->back()->with('error', 'Błędna data.');
				}

				//Sprawdzenie numeru PESEL
				if(!CheckPESEL($pesel) || strlen($pesel ) != 11 || hasLetters($pesel))
				{
					return redirect()->back()->with('error', 'Błędny numer PESEL.');
				}

				//Porównanie PESELU z datą urodzenia
				$dzien   = substr($pesel, 4, 2);
				$miesiac = substr($pesel, 2, 2);
				$rok     = substr($pesel, 0, 2);

				if(substr($dataUrodzenia, 8, 2) != $dzien || substr($dataUrodzenia, 5, 2) != $miesiac || substr($dataUrodzenia, 2, 2) != $rok)
				{
					return redirect()->back()->with('error', 'Wprowadzona data nie zgadza się z numerem PESEL.');
				}

				if(strlen($login) > 16 || strlen($login) < 5)
				{
					return redirect()->back()->with('error', 'Błędny login lub hasło.');
				}

				if(DB::table('users')->where('id', 'not like', $id)->where("login", $login)->first() != "")
				{
					return redirect()->back()->with('error', 'Podany login jest już przypisany do innego użytkownika.');
				}
		        

		        DB::table('users')->where('id', $id)->update([
		        	'login' => $login,
 		        	'imie' => $imie,
		        	'nazwisko' => $nazwisko,
		        	'pesel' => $pesel,
		        	'data_ur' => $dataUrodzenia,
		        	'funkcja' => $funkcja
		        ]);
		        if($password != "")
		        {
		        	if(strlen($password) < 5 || strlen($password) > 16)
			        {
			        	return redirect()->back()->with('error', 'Błędny login lub hasło.');
			    	}
		        	 DB::table('users')->where('id', $id)->update([
		        	'haslo' => HASH::make($password)
		        	]);
		        }
				return redirect()->back()->with('message', 'Dane użytkownika zostały zaktualizowane.');
			break;
			case "addPhoto":
				$file 			= $request->file('image');
				$idPacjenta     = $request->input('id');

				// if($file == null)
				// {
				// 	 return redirect()->back()->with('error', 'Proszę wybrać zdjęcie do dodania.')->with("photoModal", $idPacjenta);
				// }
				if($file->getClientOriginalExtension() != "png" && $file->getClientOriginalExtension() != "jpg")
				{
					return redirect()->back()->with('error', 'Wybrano niepoprawne rozszerzenie pliku! Dozwolone jest PNG lub JPG.')->with("photoModal", $idPacjenta);
				}
				$destinationPath = 'pictures/original';
				$fileName = "";
				if(DB::table('photos')->first() == "")
				{
					$fileName = "1".$file->getClientOriginalName();
				} else {
			    $fileName = (DB::table('photos')->orderBy('id', 'desc')->first()->id+1).$file->getClientOriginalName();
				}
			    $file->move($destinationPath,$fileName);

			    DB::table('photos')->insert(
			    [
			    	'directory' => $destinationPath."/".$fileName,
			    	'data' => date("Y-m-d"),
			    	'oryginal'  => true,
			    	'id_pacjenta' => $idPacjenta
			    ]);

			    return redirect()->back()->with('message', 'Zdjęcie dodane poprawnie.')->with("photoModal", $idPacjenta);
			break;
			case "colorPhoto":
				// Implementacja funkcji kolorującej napisanej przez Michała Żebrowskiego
				$idPacjenta       = $request->input("patientId");
				$notColoured = $request->input('coloured');
				if($notColoured != 1)
				{
					return redirect()->back()->with('error', 'Nastąpił błąd.')->with("photoModal", $idPacjenta);
				}

				if(Session::has('user')){
					if(DB::table('users')->where("id", session()->get('user'))->first()->funkcja == "ordynator")
					{
						return redirect()->back()->with('error', 'To konto nie ma uprawnień do kolorowania zdjęć.')->with("photoModal", $idPacjenta);
					}
				}

				/**
				 * createImage()	- Tworzy nowy obraz z pliku
				 * @param string	$filename nazwa pliku
				 * 
				 * @return zwraca obraz lub w przypadu niepowodzenia false;
				 */
				function createImage($filename){
						switch (exif_imagetype($filename)) {
							case IMAGETYPE_GIF:
								return imagecreatefromgif($filename);
							case IMAGETYPE_JPEG:
								return imagecreatefromjpeg($filename);
							case IMAGETYPE_PNG:
								return imagecreatefrompng($filename);
							case IMAGETYPE_BMP:
								return imagecreatefrombmp($filename);
							default:
								exit("Unsupported file type ($filename)");
					}
				}

				function generateNewFilename($orginalFilename, $extension){
					$exploded = explode('.', $extension);
					$firstPart = implode('.', explode('.', $orginalFilename, -1));
					
					return $firstPart . "_co_" . date("dmY_G.i_") . substr(md5(rand()), 0, 7) . "." . end($exploded);;
				}

				// Ustawianie zmiennych
				$filename = DB::table('photos')->where('id', $id)->first()->directory;
				$to = generateNewFilename($filename, '.bmp');
				$paletteName = 'palettes/palette.png';

				// Kolorowanie zdjęcia
				if (!file_exists ( $filename )) {
					return redirect()->back()->with('error', 'Zdjęcie '.$filename.' nie istnieje.')->with("photoModal", $idPacjenta);
				}

				if (!file_exists ( $paletteName )) {
					return redirect()->back()->with('error', 'Paleta barw '.$paletteName.' nie istnieje.')->with("photoModal", $idPacjenta);
				}
				
				if(!($image = createImage($filename))){
					return redirect()->back()->with('error', 'Nie można załadować tego zdjęcia.')->with("photoModal", $idPacjenta);
				}
				
				if(!($palette = createImage($paletteName))){
					return redirect()->back()->with('error', 'Nie można załadować tej palety barw.')->with("photoModal", $idPacjenta);
				}
				
			    $size = getimagesize($filename);
			    $sizePalette = getimagesize($paletteName);
			    
				$width  = $size[0];
			    $height = $size[1];
				
				$widthPalette  = $sizePalette[0];
			    $heightPalette = $sizePalette[1];
				
				// TODO: maxsixe do zapytania na zajeciach
				if($width <= 0 || $height <= 0){
					return redirect()->back()->with('error', 'Zdjęcie ma nieprawidłowe wymiary.')->with("photoModal", $idPacjenta);
				}
				
				$minWidthPalette = 255;
				
				// TODO: maxsixe do zapytania na zajeciach
				if($widthPalette <= $minWidthPalette || $heightPalette <= 0){
					return redirect()->back()->with('error', 'Paleta barw ma nieprawidłowe wymiary.')->with("photoModal", $idPacjenta);
				}
				
				$colorMax = 255;
				$factor = $widthPalette / $colorMax;
				
			    for($x=0;$x<$width;$x++)
			    {
			        for($y=0;$y<$height;$y++)
			        {
			            $rgb = imagecolorat($image, $x, $y);
			            $r = ($rgb >> 16) & 0xFF;
			            $g = ($rgb >> 8) & 0xFF;
			            $b = ($rgb >> 0) & 0xFF;
						
						if($r != $g && $r != $b) {
							return redirect()->back()->with('error', 'Wybrane zdjęcie nie jest czarno-białe.')->with("photoModal", $idPacjenta);
						}
						
						$newColor = intval($r * $factor);
						
						if($newColor >= $widthPalette) {
						 	$newColor = $widthPalette - 1;
						}
						
			            $rgbPalette = imagecolorat($palette, $newColor , 0);	
						
						imagesetpixel($image, $x, $y, $rgbPalette);	
			        }
			    }
				
				$preferedExitension = 'bmp';
				$extension = explode('.', $to);
				if(end($extension) !== $preferedExitension){
					return redirect()->back()->with('error', 'Nieodpowiednie rozszerzenie pliku wyjściowego '.$to.'.')->with("photoModal", $idPacjenta);
				}

				if (file_exists ( $to )) {
					return redirect()->back()->with('error', 'Istnieje plik to tej samej nazwie '.$to.'.')->with("photoModal", $idPacjenta);
				}
				
				// Wyjściowo png
				imagepng($image, $to);
					
				// Free up memory
				imagedestroy($image);
				imagedestroy($palette);

				

				DB::table('coloured')->insert(
                [
                'directory' => $to,
                'date' => date("Y-m-d"),
                'original_id' => $id
                ]);
	

				return redirect()->back()->with('message', 'Zdjęcie zostało pokolorowane poprawnie.')->with("photoModal", $idPacjenta);
			break;
			case "deletePhoto":
				$id      = $request->input('id');
				$idPacjenta       = $request->input("patientId");
				$notColoured = $request->input('coloured');

				if($notColoured == 1)
				{
					unlink(DB::table('photos')->where('id', $id)->first()->directory);
					DB::table('photos')->where('id', $id)->delete();
					if(DB::table('coloured')->where('original_id', $id)->first() != "")
					{
						unlink(DB::table('coloured')->where('original_id', $id)->first()->directory);
						DB::table('coloured')->where('original_id', $id)->delete();
					}
				} else {
					unlink(DB::table('coloured')->where('id', $id)->first()->directory);
					DB::table('coloured')->where('id', $id)->delete();
				}

				return redirect()->back()->with('message', 'Zdjęcie usunięte poprawnie.')->with("photoModal", $idPacjenta);
			break;
		}
		return redirect()->back()->with('error', 'Nastąpił błąd.')->with("photoModal", $id);
	}


	public function zaloguj( Request $request )
	{
		$login = DB::table('users')->where('login', $request->input("username"))->first();
		if($login != "")
		{
			if(Hash::check($request->input("password"), $login->haslo))
			{
				DB::table('users')->where('login', $request->input("username"))->update([
		        	'lastLogin' => date("d.m G:i:s")  
		        ]);
				if($login->funkcja == "admin")
				{
					Session::put('admin', 'true');
					Session::put('adminid', $login->id);
					return redirect("/admin");
				} else
				{
					Session::put('logged', 'true');
					Session::put('user', $login->id);
					return redirect("/dashboard");
				}
			} 
		}

		session()->forget('logged');
		session()->forget('user');
		session()->forget('admin');
		return redirect()->back()->with('message', 'Błędny login lub hasło');
	}

	public function wyloguj()
	{
		session()->forget('logged');
		session()->forget('user');
		session()->forget('admin');

		return redirect('/');
	}
}
