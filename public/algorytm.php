<?php
///Implementacja algorytmu kolorującego zdjęcia
/// PHP version 7.2
///@author     LeoProXXX
/// @version    2.0



/// Klasa służąca do kolorowania zdjęć

class Picture {
	private $image;
	private $palette;
	private $inputFilePath;
	private $paletteFilePath;
	
	 ///Kontruktor
	/// @param string $filename nazwa pliku do pokolorowania
	/// @param string $paletteName nazwa palety
	
	public function __construct($inputFilePath , $paletteFilePath)
	{
		if (!file_exists ( $inputFilePath  )) {
			exit("Your file doesn't exist ($inputFilePath )");
		}
		
		if (!file_exists ( $paletteFilePath )) {
			exit("Palette doesn't exist ($paletteFilePath)");
		}
		
		if(!($this->image = $this->createImage($inputFilePath ))){
			exit("Sorry, we can not load this picture ($inputFilePath )");
		}
		
		if(!($this->palette = $this->createImage($paletteFilePath))){
			exit("Sorry, we can not load color palette ($paletteFilePath)");
		}
		
		$this->inputFilePath  = $inputFilePath ;
		$this->paletteFilePath = $paletteFilePath;
	}
	
	
	///Destruktor zwalniający zasoby
	
    public function __destruct()
	{ 
		// Free up memory
		if(is_resource($this->image)) { 
			imagedestroy($this->image); 
		}
		
		if(is_resource($this->palette)) { 
			imagedestroy($this->palette); 
		}
	}
	
	
	/// Metoda tworząca nowy obraz z pliku
	/// @param string $filePath nazwa pliku
	/// @return zwraca obraz lub w przypadu niepowodzenia false;
	private function createImage($filePath){
		switch (exif_imagetype($filePath)) {
			case IMAGETYPE_GIF:
				return imagecreatefromgif($filePath);
			case IMAGETYPE_JPEG:
				return imagecreatefromjpeg($filePath);
			case IMAGETYPE_PNG:
				return imagecreatefrompng($filePath);
			case IMAGETYPE_BMP:
				return imagecreatefrombmp($filePath);
			default:
				exit("Unsupported file type ($filePath)");
		}
	}
	
	
	///Metoda kolorująca zdjęcie
	
	public function colorize(){	
		$size = getimagesize($this->inputFilePath );
		$sizePalette = getimagesize($this->paletteFilePath);
		
		$width  = $size[0];
		$height = $size[1];
		
		$widthPalette  = $sizePalette[0];
		$heightPalette = $sizePalette[1];
		
		
		if($width <= 0 || $height <= 0){
			exit("Image is incorrect size ($inputFilePath )");
		}
		
		$minWidthPalette = 255;
		
		
		if($widthPalette <= $minWidthPalette || $heightPalette <= 0){
			exit("Palette is incorrect size ($paletteFilePath)");
		}
		
		$colorMax = 255;
		$factor = $widthPalette / $colorMax;
		
		for($x=0;$x<$width;$x++)
		{
			for($y=0;$y<$height;$y++)
			{
				$rgb = imagecolorat($this->image, $x, $y);
				$r = ($rgb >> 16) & 0xFF;
				$g = ($rgb >> 8) & 0xFF;
				$b = ($rgb >> 0) & 0xFF;
				
				if($r != $g && $r != $b) {
					exit("The picture is not black and white ($inputFilePath )");
				}
				
				$newColor = intval($r * $factor);
				
				if($newColor >= $widthPalette) {
					$newColor = $widthPalette - 1;
				}
				
				$rgbPalette = imagecolorat($this->palette, $newColor , 0);	
				
				imagesetpixel($this->image, $x, $y, $rgbPalette);	
			}
		}
	}
	
	
	///Metoda zapisująca pokolorowany obraz do pliku
	/// @param string $outputFilePath ścieżka do zapisu zdjęcia
	
	public function save($outputFilePath) {
		$preferedExitension = 'bmp';
		$extension = explode('.', $outputFilePath );
		if(end($extension) !== $preferedExitension){
			exit('We prefer ".bmp" extension ' . "($outputFilePath )");
		}
	
		if (file_exists ( $outputFilePath  )) {
			exit("Sorry, file already exists ($outputFilePath )");
		}
		
		
		imagebmp($this->image, $outputFilePath );
	}
	
	/// Metoda generująca nową nazwe pliku na podstawie starej (orginalnej) nazwy	
	/// @param string $orginalFilename nazwa pliku orginalnego (czarno-białego)
	/// @param string $extension	 rozszerzenie dla pliku pokolorowanego
	/// @return wygenerowana nowa nazwa pliku
	
	public function generateNewFilename($orginalFilename, $extension) {
		$exploded = explode('.', $extension);
		$firstPart = implode('.', explode('.', $orginalFilename, -1));
		
		return $firstPart . "_co_" . date("dmY_G.i_") . substr(md5(rand()), 0, 7) . "." . end($exploded);;
	}
}
	
	/// Ustawianie zmiennych
	$orginal_file_path = 'pictures/test.png';
	$palette_file_path = 'palettes/palette.png';
	
	/// Tworzymy instancje no
	$picture = new Picture($orginal_file_path, $palette_file_path);
	/// Kolorowanie zdjęcia
	$picture->colorize();
	/// Generowanie nowej nazwy pliku
	$new_file_name = $picture->generateNewFilename($orginal_file_path, '.bmp');
	/// Zapisywanie pokolorowanego pliku
	$picture->save($new_file_name);
