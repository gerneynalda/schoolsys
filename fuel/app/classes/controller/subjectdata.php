<?php

Class Controller_Subjectdata extends Controller_Rest
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
		$subject = Model_Subject::find("all");
		return $this->response(array(
			"message"	=> "Listing all subject.",
			"data"	=> $subject
		));
	}

	public function post_create()
	{

		$name = Input::json("name");
		$description = Input::json("description");

		$create = Model_Subject::forge(array(
			"name" => $name,
			"description" => $description
		));

		if($create->save()) {

			$this->response(array(
				"success" => true,
				"message" => "New subject has been created.",
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
        $id = Input::json('subjectid');
		$name = Input::json('name');
		$description = Input::json('description');
	
		$subject = Model_Subject::find($id);
	
		if($subject) {

			$subject->name = $name;
			$subject->description = $description;

			if($subject->save()) {

				return $this->response(array(
					"success" => true,
					"message" => "Subject name has been updated.",
					"data" => $subject
				));

			}else {
				
				return $this->response(array(
					"success" => false,
					"message" => "Something went wrong, unable to update subject name.",
					"data" => $subject
				));

			}

		}else {

			return $this->response(array(
				"success" => false,
				"message" => "This subject no longer exist.",
				"data" => []
			));

		}
    }

	public function delete_delete()
	{
		$subjectid = Input::get("subjectid");

		$sql = "DELETE FROM `subjects` WHERE `id`=".$subjectid;
		$result = DB::query($sql)->as_object("Model_subject")->execute();

		if($result) {
			return $this->response(array(
				"success" => true,
				"message" => "subject has been deleted.",
				"data"	=> []
			));
		}else{
			return $this->response(array(
				"success" => false,
				"message" => "Something went wrong, unable to delete subject.",
				"data"	=> []
			));
		}
		
	}
}