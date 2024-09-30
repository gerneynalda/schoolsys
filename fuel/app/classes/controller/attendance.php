<?php

class Controller_Attendance extends Controller_Template
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
		// get level list
		$sql = "SELECT * FROM `levels`";
		$levels = DB::query($sql)->execute()->as_array("id");
		// get sectino list
		$sql = "SELECT * FROM `sections`";
		$sections = DB::query($sql)->execute()->as_array("id");
		// get schoolyear list
		$schoolyears = Model_Schoolyear::find("all");
		// get class list
		$classes = Model_Class::find("all");

		$custom_menu = '<form class="navbar-form navbar-right">';

		// schoolyears
		$custom_menu .= '<div class="form-group form-group-sm">';
		$custom_menu .= '<select class="form-control" id="select-schoolyear-dropdown">';
		$custom_menu .= '<option value="">Select School year</option>';
		foreach($schoolyears as $schoolyear) {
			$custom_menu .= '<option value="'.$schoolyear->id.'">'.$schoolyear->name.'</option>';
		}
		$custom_menu .= '</select>';
		$custom_menu .= '</div>';
		
		// classes
		$custom_menu .= '<div class="form-group form-group-sm">';
		$custom_menu .= '<select class="form-control" id="select-class-dropdown">';
		$custom_menu .= '<option value="">Select Class</option>';
		foreach($classes as $class) {
			$custom_menu .= '<option value="'.$class->id.'">'.$levels[$class->level_id]["name"].' '.$sections[$class->section_id]["name"].'</option>';
		}
		$custom_menu .= '</select>';
		$custom_menu .= '</div>';	

		$custom_menu .= '<button type="button" class="btn btn-primary btn-sm" id="get-attendance-btn">Get Attedance</button>';
		$custom_menu .= '<a type="button" class="btn btn-primary btn-sm" href='.Config::get("base_url")."schooldays".'><i class="fa-solid fa-cog"></i></a>';
		$custom_menu .= '</form>';

		// show subject grades table or trait grades table
		$custom_menu .= '<div class="btn-group navbar-form navbar-left" role="group" aria-label="...">
		<button type="button" class="btn btn-primary btn-sm active" id="show-monthly-attendance-table-btn">Monthly Attendance</button>
		<button type="button" class="btn btn-primary btn-sm" id="show-daily-attendance-table-btn">Daily Attendance</button>
		</div>';

		// days tardy inputs | days present inputs
		$custom_menu .= '<div class="btn-group navbar-form navbar-left" role="group" aria-label="...">
		<button type="button" class="btn btn-primary btn-sm active" id="show-days-present-inputs-btn">Present</button>
		<button type="button" class="btn btn-primary btn-sm" id="show-days-tardy-inputs-btn">Tardy</button>
		</div>';

		// send menu to the template
		$this->template->set('customMenu', $custom_menu, false);
		// custom script
		$this->template->set_global("scripts", ["createattendance.js"]);
		// custom styles
		$this->template->set_global('styles', ["attendance.css"]);
		$this->template->title = 'Attendance &raquo; Index';
		$this->template->content = View::forge('attendance/index');
	}

}