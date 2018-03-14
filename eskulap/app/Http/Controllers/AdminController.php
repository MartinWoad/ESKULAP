<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DOMDocument;
use DOMXPath;

use DB;

class AdminController extends Controller
{

	public function zarejestruj( Request $request )
	{

		if(DB::table('users')->where('login', $request->input("username"))->first() != "")
		{
			return redirect()->back()->with('error', 'Wybrany login jest zajęty');
		}

		$funkcja = $request->input('funkcja');
		switch($funkcja)
		{
			case "lekarz":
			case "ordynator":
				$imie           = $request->input('forename');
				$nazwisko       = $request->input('surname');
				$data_urodzenia = $request->input('dateOfBirth');
				$login          = $request->input('username');
				$haslo          = $request->input('password');
				$pesel          = $request->input('pesel');
				$ip             = "127.0.0.1";
				$funkcja 		= $request->input('funkcja');

				DB::table('users')->insert(
                [
                'login' => $login, 
                'haslo' => $haslo,
                'imie' => $imie,
                'nazwisko' => $nazwisko,
                'haslo' => $haslo,
                'pesel' => $pesel,
                'data_ur' => $data_urodzenia,
                'funkcja' => $funkcja,
                'adres_ip' => "127.0.0.1"
                ]);

			break;
			case "pacjent":
				$imie           = $request->input('forename');
				$nazwisko       = $request->input('surname');
				$pesel          = $request->input('pesel');
				$plec 			= $request->input('gender');
				$data_urodzenia = $request->input('dateOfBirth');
				$id_lekarza     = $request->input('patientsDoctor');

				DB::table('patients')->insert(
                [
                'imie' => $imie,
                'nazwisko' => $nazwisko,
                'pesel' => $pesel,
                'plec'  => $plec,
                'data_ur' => $data_urodzenia,
                'id_lekarza' => $id_lekarza
                ]);

			break;
			default:
				return redirect()->back()->with('error', 'Nie wybrano właściwej funkcji');
			break;
		}
		return redirect()->back()->with('message', 'Rejestracja zakończona sukcesem');
	}
}
