<?php

class Controller_Createclass extends Controller_Template
{
	public function before()
	{
		parent::before();
		// add new asset path
		Asset::add_path("assets/fontawesome-free-6.5.2-web/css/", "css");
		Asset::add_path("assets/fontawesome-free-6.5.2-web/js/", "js");

		// load core styles and core scripts
		$this->template->set_global('core_styles', ['bootstrap.css', 'all.min.css', 'system-notification.css', 'core_styles.css']);
		$this->template->set_global('core_scripts', ['jquery-v.3.7.1.min.js', 'bootstrap.min.js', 'all.min.js', 'system-notifications.js', 'get-data-functions.js', 'create-data-functions.js', 'delete-data-functions.js', 'update-data-functions.js']);
	}


	public function action_index()
	{
		// controller specific styles and scripts
		$this->template->set_global("styles", array("style.css"));
		$this->template->set_global("scripts", array("createclass.js"));
		
		$this->template->title = 'Createclass &raquo; Index';
		$this->template->content = View::forge('createclass/index');
	}

}
