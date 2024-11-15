<?php

class Controller_Schooldays extends Controller_Template
{
	public function before()
	{
		parent::before();

		if(!Auth::check()) {

			Response::redirect('authenticate/login');
		}
		
		// add new asset path
		Asset::add_path("assets/fontawesome-free-6.5.2-web/css/", "css");
		Asset::add_path("assets/fontawesome-free-6.5.2-web/js/", "js");

		// load core styles and core scripts
		$this->template->set_global('core_styles', ['bootstrap.css', 'all.min.css', 'system-notification.css', 'core_styles.css']);
		$this->template->set_global('core_scripts', ['jquery-v.3.7.1.min.js', 'bootstrap.min.js', 'all.min.js', 'system-notifications.js', 'get-data-functions.js', 'create-data-functions.js', 'delete-data-functions.js', 'update-data-functions.js']);
	}

	public function action_index()
	{

		// get schoolyear list
		$schoolyears = Model_Schoolyear::find("all");
		$schoolyear_list = '';

		// schoolyears
		$schoolyear_list .= '<ul class="list-group" id="schoolyear-list">';
		foreach($schoolyears as $schoolyear) {
			$schoolyear_list .= '<li class="list-group-item" data-id="'.$schoolyear->id.'" data-description="'.$schoolyear->name.'">'.$schoolyear->name.'</li>';
		}
		$schoolyear_list .= '</ul>';

		$custom_menu = '<form class="navbar-form navbar-right">'; 
		$custom_menu .= '<a type="button" class="btn btn-primary btn-sm" href='.Config::get("base_url")."attendance".'>Attendance</a>';
		$custom_menu .= '<a type="button" class="btn btn-primary btn-sm" href='.Config::get("base_url")."schooldays".'><i class="fa-solid fa-cog"></i></a>';
		$custom_menu .= '</form>';
		// send menu to the template
		$this->template->set('customMenu', $custom_menu, false);

		$this->template->set_global('styles', ["attendance.css"]);
		$this->template->set_global('scripts', ["createschooldays.js"]);
		$this->template->title = 'Schooldays &raquo; Index';
		$this->template->content = View::forge('schooldays/index', ['schoolyear_list' => $schoolyear_list], false);
	}

}
