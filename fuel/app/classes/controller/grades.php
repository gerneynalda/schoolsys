<?php

class Controller_Grades extends Controller_Template
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
		// Read files folder to check for datafiles
		// controller specific styles and scripts
		$this->template->set_global("styles", array("style.css"));

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
		// get curriculum list
		$curriculums = Model_Curriculum::find("all");
		// get strand list
		$strands = Model_Strand::find("all");
		// get semester list
		$semesters = Model_Semester::find("all");
		// get period list
		$periods = Model_Period::find("all");

		$custom_menu = '';

		$custom_menu .= '<form class="navbar-form navbar-right">';
		
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

		// curriculums
		$custom_menu .= '<div class="form-group form-group-sm">';
		$custom_menu .= '<select class="form-control" id="select-curriculum-dropdown">';
		$custom_menu .= '<option value="">Select Curriculum</option>';
		foreach($curriculums as $curriculum) {
			$custom_menu .= '<option value="'.$curriculum->id.'">'.$curriculum->name.'</option>';
		}
		$custom_menu .= '</select>';
		$custom_menu .= '</div>';

		// strands
		$custom_menu .= '<div class="form-group form-group-sm">';
		$custom_menu .= '<select class="form-control" id="select-strand-dropdown">';
		$custom_menu .= '<option value="">Select Strand</option>';
		foreach($strands as $strand) {
			$custom_menu .= '<option value="'.$strand->id.'">'.$strand->name.'</option>';
		}
		$custom_menu .= '</select>';
		$custom_menu .= '</div>';

		// semesters
		$custom_menu .= '<div class="form-group form-group-sm">';
		$custom_menu .= '<select class="form-control" id="select-semester-dropdown">';
		$custom_menu .= '<option value="">Select Semester</option>';
		foreach($semesters as $semester) {
			$custom_menu .= '<option value="'.$semester->id.'">'.$semester->name.'</option>';
		}
		$custom_menu .= '</select>';
		$custom_menu .= '</div>';

		// periods
		$custom_menu .= '<div class="form-group form-group-sm">';
		$custom_menu .= '<select class="form-control" id="select-period-dropdown">';
		$custom_menu .= '<option value="">Select Period</option>';
		foreach($periods as $period) {
			$custom_menu .= '<option value="'.$period->id.'">'.$period->name.'</option>';
		}
		$custom_menu .= '</select>';
		$custom_menu .= '</div>';

		$custom_menu .= '<button type="button" class="btn btn-primary btn-sm" id="start-query">Submit</button>';
		$custom_menu .= '</form>';

		// show subject grades table or trait grades table
		$custom_menu .= '<div class="btn-group navbar-form navbar-left" role="group" aria-label="Select subject or trait operation.">
		<button type="button" class="btn btn-primary btn-sm active" id="show-subject-grades-table-btn">Subjects</button>
		<button type="button" class="btn btn-primary btn-sm" id="show-trait-grades-table-btn">Traits</button>
		</div>';

		// toggle tabbing horizontal tabbing (normal);
		// vertical tabbing
		$custom_menu .= '<form class="navbar-form navbar-left" role="search">
		<div class="input-group">
		<span class="input-group-addon">
			<input type="checkbox" aria-label="Toggle horizontal or vertical tabbing" id="toggle-tabbing" checked>
		</span>
		<input type="text" class="form-control input-sm" aria-label="Tabbing indication." id="tabbing-description" value="Vertical Tabbing">
		</div>
		</form>
		';
		
		// send menu to the template
		$this->template->set('customMenu', $custom_menu, false);
		// script
		$this->template->set_global("scripts", ["creategrades.js"]);
		// styles
		$this->template->set_global('styles', ["grades.css"]);
		$this->template->title = 'Student Grades';
		$this->template->content = View::forge('grades/index', null, false);
	}

}
