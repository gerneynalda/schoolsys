<?php

Class Controller_Semesterdata extends Controller_Rest
{
    public function before()
    {
        parent::before();

		if(!Auth::check()) {

			Response::redirect('authenticate/login');
		}
		
        $this->response->set_header("Access-Control-Allow-Origin", '*');
        $this->response->set_header("Access-Control-Allow-Header", "AccountKey,x-requested-with, Content-Type, origin, authorization, accept, client-security-token, host, date, cookie, cookie2");
        $this->response->set_header("Access-Control-Max-Age", '60');
        $this->response->set_header("Access-Control-Allow-Methods", "GET, POST, PUT, DELETE, OPTIONS");
    }

	public function get_list()
	{
		$semester = Model_Semester::find("all");
		return $this->response(array(
			"message"	=> "Listing all semester.",
			"data"	=> $semester
		));
	}

	public function post_create()
	{

		$name = Input::json("name");

		$create = Model_Semester::forge(array(
			"name" => $name
		));

		if($create->save()) {

			$this->response(array(
				"success" => true,
				"message" => "New semester has been created.",
				"data" => $create
			));

		}else {

			$this->response(array(
				"success" => false,
				"message" => "Something went wrong, unable to save data.",
				"data" => []
			));

		}

	}

    public function put_edit()
    {
        $id = Input::json('semesterid');
		$name = Input::json('name');
	
		$semester = Model_Semester::find($id);
	
		if($semester) {

			$semester->name = $name;

			if($semester->save()) {

				return $this->response(array(
					"success" => true,
					"message" => "Semester name has been updated.",
					"data" => $semester
				));

			}else {
				
				return $this->response(array(
					"success" => false,
					"message" => "Something went wrong, unable to update semester name.",
					"data" => $semester
				));

			}

		}else {

			return $this->response(array(
				"success" => false,
				"message" => "This semester no longer exist.",
				"data" => []
			));

		}
    }

	public function delete_delete()
	{
		$semesterid = Input::get("semesterid");

		$sql = "DELETE FROM `semesters` WHERE `id`=".$semesterid;
		$result = DB::query($sql)->as_object("Model_Semester")->execute();

		if($result) {
			return $this->response(array(
				"success" => true,
				"message" => "Semester has been deleted.",
				"data"	=> []
			));
		}else{
			return $this->response(array(
				"success" => false,
				"message" => "Something went wrong, unable to delete semester.",
				"data"	=> []
			));
		}
		
	}
}