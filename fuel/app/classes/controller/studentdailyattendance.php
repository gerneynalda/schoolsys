<?php

class Controller_Studentdailyattendance extends Controller_Template
{	

	public $template = "non_admin_template";

	public function before() {
		parent::before();
	}

	public function action_index()
	{
		
		$css = [];
		$css[] = "studentdailyattendance.css";

		$this->template->css = $css;
		$this->template->title = 'Studentdailyattendance &raquo; Index';
		$this->template->content = View::forge('studentdailyattendance/index');
	}

}
