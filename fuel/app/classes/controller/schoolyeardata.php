<?php

class Controller_Schoolyeardata extends Controller_Rest
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
		$schoolyears = Model_Schoolyear::find("all");

		return $this->response(array(
			"message" => "Listing all school year.",
			"data" => $schoolyears
		));
	}

	public function post_add()
	{

		$name = Input::json("name");

		$create = Model_Schoolyear::forge(array(
			"name" => $name
		));

		if($create->save()) {

			$this->response(array(
				"success" => true,
				"message" => "New schoolyear has been created.",
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

	public function delete_delete()
	{
		$id = Input::get("schoolyearid");

		$sql = "DELETE FROM `schoolyears` WHERE `id` = ".$id;
		$schoolyear = DB::query($sql)->as_object("Model_Schoolyear")->execute();

		// check if a record with this $id exists.
		if(!$schoolyear) {

			return $this->response(array(
				"success" => false,
				"message" => "This schoolyear no longer exist.",
				"data"	=> []
			));

		}

		if($schoolyear) {

			return $this->response(array(
				"success" => true,
				"message" => "Schoolyear has been deleted.",
				"data"	=> []
			));

		}else{

			return $this->response(array(
				"success" => false,
				"message" => "Something went wrong, unable to delete schoolyear.",
				"data"	=> []
			));

		}

	}

	public function put_edit() {

		$id = Input::put('schoolyearid');
		$name = Input::put('name');
		
		$schoolyear = Model_Schoolyear::find($id);
	
		if($schoolyear) {

			$schoolyear->name = $name;

			if($schoolyear->save()) {

				return $this->response(array(
					"success" => true,
					"message" => "School year name has been updated.",
					"data" => $schoolyear
				));

			}else {
				
				return $this->response(array(
					"success" => false,
					"message" => "Something went wrong, unable to update level name.",
					"data" => $schoolyear
				));

			}

		}else {

			return $this->response(array(
				"success" => false,
				"message" => "This school year no longer exist.",
				"data" => []
			));

		}

	}
}
