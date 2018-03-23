<?php


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Tutaj znajdują się ścieżki sieciowe naszej aplikacji.
|
*/


/*
	Panel logowania
	Wyświetlany: jako strona główna, po zalogowaniu (z uruchomioną sesją) 
	przejście do tej ścieżki przekieruje użytkownika do panelu zarządzania jego pacjentami.
*/
Route::get('/', function () {
    return view('logowanie');
});

Route::post('/', 'MainController@zaloguj');


Route::post('/funkcje', 'MainController@funkcje');

Route::post('/getPhotos', 'MainController@getPhotos');

/*
	Panel administratora
	Wyświetlany - tylko po zalogowaniu się z wykorzystaniem danych administratora.
*/
Route::get('/admin', function () {
    return view('admin.main');
});

Route::get('/rejestracja', 'AdminController@formularzRejestracji');
Route::post('/rejestracja', 'AdminController@zarejestruj');

Route::get('/listapracownikow', function(){
	return view('admin.listapracownikow');
});


/*
	Panel zarządzania
	Wyświetlany - tylko po zalogowaniu się z wykorzystaniem danych lekarza, ordynatora lub admina.
*/
Route::get('/dashboard', function () {
	$user  = session()->get('logged');
	$admin = session()->get('admin');

	if($admin == "true")
	{
		return view('admin.main');
	}
	
	if($user == "true")
	{
		return view('user.main');
	}

	return redirect('/');
});


Route::get('/nowypacjent', function() {
	return view('user.nowypacjent');
});


Route::get('/listapacjentow', function(){
	$user  = session()->get('logged');
	$admin = session()->get('admin');

	if($admin == "true")
	{
		return view('admin.listapacjentow');
	}
	
	if($user == "true")
	{
		return view('user.listapacjentow');
	}

	return redirect('/');
});


/*
	Wylogowywanie
*/
Route::get('/logout', 'MainController@wyloguj');