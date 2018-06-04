<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @author   Taylor Otwell <taylor@laravel.com>
 */

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

///Ten plik pozwala nam emulować funkcjonalność Apache'a "mod_rewrite" z 
///wbudowanego serwera sieciowego PHP. Zapewnia to wygodny sposób testowania Laravela
/// bez zainstalowanego "prawdziwego" oprogramowania serwera WWW.
if ($uri !== '/' && file_exists(__DIR__.'/public'.$uri)) {
    return false;
}

require_once __DIR__.'/public/index.php';
