<?php

class Controller_Createcurriculum extends Controller_Template
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

		$custom_menu = '<div class="btn-group navbar-form navbar-right" role="group" aria-label="...">
		<button type="button" class="btn btn-primary btn-sm active" id="show-subjects-panel"><i class="fa-solid fa-table-list"></i> Subjects</button>
		<button type="button" class="btn btn-primary btn-sm" id="show-traits-panel"><i class="fa-solid fa-table-list"></i> Traits</button>
		</div>';

		// send menu to the template
		$this->template->set('customMenu', $custom_menu, false);

		// controller specific styles and scripts
		$this->template->set_global("styles", array("style.css"));
		$this->template->set_global("scripts", array("createcurriculum.js"));

		$this->template->title = 'Createcurriculum';
		$this->template->content = View::forge('createcurriculum/index');
	}

}
