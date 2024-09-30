<?php

Class Controller_Curriculumdata extends Controller_Rest
{
    public function before()
    {
        parent::before();
        $this->response->set_header("Access-Control-Allow-Origin", '*');
        $this->response->set_header("Access-Control-Allow-Header", "AccountKey,x-requested-with, Content-Type, origin, authorization, accept, client-security-token, host, date, cookie, cookie2");
        $this->response->set_header("Access-Control-Max-Age", '60');
        $this->response->set_header("Access-Control-Allow-Methods", "GET, POST, PUT, DELETE, OPTIONS");
    }

	public function get_list()
	{
		$curriculum = Model_Curriculum::find("all");
		return $this->response(array(
			"message"	=> "Listing all curriculum.",
			"data"	=> $curriculum
		));
	}

	public function post_create()
	{

		$name = Input::json("name");

		$create = Model_Curriculum::forge(array(
			"name" => $name
		));

		if($create->save()) {

			$this->response(array(
				"success" => true,
				"message" => "New curriculum has been created.",
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
        $id = Input::json('curriculumid');
		$name = Input::json('name');
	
		$curriculum = Model_Curriculum::find($id);
	
		if($curriculum) {

			$curriculum->name = $name;

			if($curriculum->save()) {

				return $this->response(array(
					"success" => true,
					"message" => "Curriculum name has been updated.",
					"data" => $curriculum
				));

			}else {
				
				return $this->response(array(
					"success" => false,
					"message" => "Something went wrong, unable to update curriculum name.",
					"data" => $curriculum
				));

			}

		}else {

			return $this->response(array(
				"success" => false,
				"message" => "This curriculum no longer exist.",
				"data" => []
			));

		}
    }

	public function delete_delete()
	{
		$curriculumid = Input::get("curriculumid");

		$sql = "DELETE FROM `curriculums` WHERE `id`=".$curriculumid;
		$result = DB::query($sql)->as_object("Model_Curriculum")->execute();

		if($result) {
			return $this->response(array(
				"success" => true,
				"message" => "Curriculum has been deleted.",
				"data"	=> []
			));
		}else{
			return $this->response(array(
				"success" => false,
				"message" => "Something went wrong, unable to delete curriculum.",
				"data"	=> []
			));
		}
		
	}
}