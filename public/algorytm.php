<?php
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
	imagebmp($image, $to);
		
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
	$orginalFilename = 'pictures/test.png';
	$newFilename = generateNewFilename($orginalFilename, '.bmp');
	$paletteFilename = 'palettes/palette.png';

	// Kolorowanie zdjęcia
	colorize($orginalFilename, $newFilename, $paletteFilename);