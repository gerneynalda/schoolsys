<?php

class Controller_Authenticate extends Controller_Hybrid
{

	public function before()
	{
		
		parent::before();
		
		
		if(Auth::check()){

			Response::redirect('grades');
		
		}

		// add new asset path
		Asset::add_path("assets/fontawesome-free-6.5.2-web/css/", "css");
		Asset::add_path("assets/fontawesome-free-6.5.2-web/js/", "js");

	}
	public function action_login()
	{

		$data = [];
		return Response::forge(View::forge('authenticate/login', $data));

	}

	public function action_logout()
	{

		$data = [];
		return Response::forge(View::forge('authenticate/logout', $data));

	}

	public function action_userLoggedIn() {

		if(Auth::login())
		{

			Response::redirect("grades");

		} else {

			$data = ["error_message"=>"Incorrect username or password."];
			return Response::forge(View::forge('authenticate/login', $data));

		}

	}

	public function action_userLoggedOut()
	{

		Auth::logout();
		Session::set_flash("logout_message", "You have successfully logout.");
		Response::redirect("authenticate/login");
		
	}

}
