<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DOMDocument;
use DOMXPath;
use Session;

use DB;

class MainController extends Controller
{
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
