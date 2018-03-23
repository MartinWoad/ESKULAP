<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
		$operacja = $request->input("action");
		$id       = $request->input("id");
		switch($operacja)
		{
			case "delete":
				if($request->input("funkcja") == "patient")
				{
					DB::table('patients')->where('id', $id)->delete();
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
		        

		        DB::table('patients')->where('id', $id)->update([
		        	'imie' => $imie,
		        	'nazwisko' => $nazwisko,
		        	'pesel' => $pesel,
		        	'plec' => $plec,
		        	'data_ur' => $dataUrodzenia,
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

		        if(strlen($password) < 5 || strlen($password) > 16)
		        {
		        	$password = DB::table('users')->where('id', $id)->first()->haslo;
		    	}

		        DB::table('users')->where('id', $id)->update([
		        	'login' => $login,
		        	'haslo' => $password,
 		        	'imie' => $imie,
		        	'nazwisko' => $nazwisko,
		        	'pesel' => $pesel,
		        	'data_ur' => $dataUrodzenia,
		        	'funkcja' => $funkcja
		        ]);

				return redirect()->back()->with('message', 'Dane użytkownika zostały zaktualizowane.');
			break;
			case "addPhoto":
				$file 			= $request->file('image');
				$idPacjenta     = $request->input('id');
				$destinationPath = 'pictures/original';
			    $fileName = (DB::table('photos')->orderBy('id', 'desc')->first()->id+1).$file->getClientOriginalName();
			    $file->move($destinationPath,$fileName);

			    DB::table('photos')->insert(
			    [
			    	'directory' => $destinationPath."/".$fileName,
			    	'data' => date("Y-m-d"),
			    	'oryginal'  => true,
			    	'id_pacjenta' => $idPacjenta
			    ]);

			    return redirect()->back()->with('message', 'Zdjęcie dodane poprawnie.');
			break;
			case "colorPhoto":
				// Wykonanie funkcji kolorującej napisanej przez Michała Żebrowskiego
				$id = $request->input('id');
				$notColoured = $request->input('coloured');
				if($notColoured != 1)
				{
					return redirect()->back()->with('error', 'Nastąpił błąd.');
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

				/**
				 * colorize()	- funkcja do kolorowania zdjęć
				 * @param string	$filename		nazwa pliku do pokolorowania
				 * @param string	$to				nazwa pliku pokolorowanego
				 * @param string	$paletteName	nazwa palety
				 */
				function colorize($filename, $to, $paletteName){
					if (!file_exists ( $filename )) {
						exit("Your file doesn't exist ($filename)");
					}
					
					if (!file_exists ( $paletteName )) {
						exit("Palette doesn't exist ($paletteName)");
					}
					
					if(!($image = createImage($filename))){
						exit("Sorry, we can not load this picture ($filename)");
					}
					
					if(!($palette = createImage($paletteName))){
						exit("Sorry, we can not load color palette ($paletteName)");
					}
					
				    $size = getimagesize($filename);
				    $sizePalette = getimagesize($paletteName);
				    
					$width  = $size[0];
				    $height = $size[1];
					
					$widthPalette  = $sizePalette[0];
				    $heightPalette = $sizePalette[1];
					
					// TODO: maxsixe do zapytania na zajeciach
					if($width <= 0 || $height <= 0){
						exit("Image is incorrect size ($filename)");
					}
					
					$minWidthPalette = 255;
					
					// TODO: maxsixe do zapytania na zajeciach
					if($widthPalette <= $minWidthPalette || $heightPalette <= 0){
						exit("Palette is incorrect size ($paletteName)");
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
								exit("The picture is not black and white ($filename)");
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
						exit('We prefer ".bmp" extension ' . "($to)");
					}

					if (file_exists ( $to )) {
						exit("Sorry, file already exists ($to)");
					}
					
					// Rozszerzenie do dogadania
					imagepng($image, $to);
						
					// Free up memory
					imagedestroy($image);
					imagedestroy($palette);
				}

				/**
				 * generateNewFilename()	- funkcja generująca nową nazwe pliku na podstawie starej (orginalnej) nazwy
				 * @param string $orginalFilename	nazwa pliku orginalnego (czarno-białego)
				 * @param string $extension			rozszerzenie dla pliku pokolorowanego
				 * 
				 * @return wygenerowana nowa nazwa pliku
				 */
				function generateNewFilename($orginalFilename, $extension){
					$exploded = explode('.', $extension);
					$firstPart = implode('.', explode('.', $orginalFilename, -1));
					
					return $firstPart . "_co_" . date("dmY_G.i_") . substr(md5(rand()), 0, 7) . "." . end($exploded);;
				}

				// Ustawianie zmiennych

				$orginalFilename = DB::table('photos')->where('id', $id)->first()->directory;
				$newFilename = generateNewFilename($orginalFilename, '.bmp');
				$paletteFilename = 'palettes/palette.png';

				// Kolorowanie zdjęcia
				colorize($orginalFilename, $newFilename, $paletteFilename);


				DB::table('coloured')->insert(
                [
                'directory' => $newFilename,
                'date' => date("Y-m-d"),
                'original_id' => $id
                ]);
	

				return redirect()->back()->with('message', 'Zdjęcie zostało pokolorowane poprawnie.');
			break;
			case "deletePhoto":
				$id      = $request->input('id');
				$notColoured = $request->input('coloured');

				if($notColoured == 1)
				{
					DB::table('photos')->where('id', $id)->delete();
				} else {
					DB::table('coloured')->where('id', $id)->delete();
				}

				return redirect()->back()->with('message', 'Zdjęcie usunięte poprawnie.');
			break;
		}
		return redirect()->back()->with('error', 'Nastąpił błąd.');
	}


	public function zaloguj( Request $request )
	{
		$login = DB::table('users')->where('login', $request->input("username"))->first();
		if($login != "")
		{
			if($request->input("password") == $login->haslo)
			{
				if($login->funkcja == "admin")
				{
					Session::put('admin', 'true');
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
