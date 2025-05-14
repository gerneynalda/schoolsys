<?php

class Controller_Settings extends Controller_Template
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

        if(Input::method() == "POST") {
           
            $old_password = trim(Input::post('old_password'));
            $new_password = trim(Input::post('new_password'));
            $reenter_password = trim(Input::post('reenter_password'));

            if(empty($old_password) || empty($new_password) || empty($reenter_password)) {

                Session::set_flash('error',"Required fields cannot be empty.");

            }else if($new_password !== $reenter_password) {

                Session::set_flash("error","New password and Re-enter password does not match.");

            }else if(!Auth::change_password($old_password, $new_password)) {

                Session::set_flash('error', 'Old password was incorrect.');
                

            }else{

                Session::set_flash('success','Change password successful. Please log in using your new password.');
                Auth::logout();
                Response::redirect('authenticate/login');
            }   
        }

        $this->template->title = 'Settings';
		$this->template->content = View::forge('settings/index');
    }
}
