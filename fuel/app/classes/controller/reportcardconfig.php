<?php

class Controller_Reportcardconfig extends Controller_Template
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

		$this->template->set_global("styles", array("reportcard.css"));
		$this->template->set_global("scripts", array("createreportcardconfig.js"));

		$this->template->title = 'Report Card Configuration';
		$this->template->content = View::forge('reportcardconfig/index', ["schoolyears" => $schoolyears]);
	}

}
