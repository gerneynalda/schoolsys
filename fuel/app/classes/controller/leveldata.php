<?php

class Controller_Leveldata extends Controller_Rest
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
		$level = Model_Level::find("all");

		return $this->response(array(
			"message" => "Listing all level.",
			"data" => $level
		));
	}

	public function post_add()
	{

		$name = Input::json("name");

		$create = Model_Level::forge(array(
			"name" => $name
		));

		if($create->save()) {

			$this->response(array(
				"success" => true,
				"message" => "New level has been created.",
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
		$id = Input::get("levelid");

		$sql = "DELETE FROM `levels` WHERE `id` = ".$id;
		$level = DB::query($sql)->as_object("Model_Level")->execute();

		// check if a record with this $id exists.
		if(!$level) {

			return $this->response(array(
				"success" => false,
				"message" => "This level no longer exist.",
				"data"	=> []
			));

		}

		if($level) {

			return $this->response(array(
				"success" => true,
				"message" => "Level has been deleted.",
				"data"	=> []
			));

		}else{

			return $this->response(array(
				"success" => false,
				"message" => "Something went wrong, unable to delete level.",
				"data"	=> []
			));

		}

	}

	public function put_edit() {

		$id = Input::put('levelid');
		$name = Input::put('name');
		
		$level = Model_Level::find($id);
	
		if($level) {

			$level->name = $name;

			if($level->save()) {

				return $this->response(array(
					"success" => true,
					"message" => "Level name has been updated.",
					"data" => $level
				));

			}else {
				
				return $this->response(array(
					"success" => false,
					"message" => "Something went wrong, unable to update level name.",
					"data" => $level
				));

			}

		}else {

			return $this->response(array(
				"success" => false,
				"message" => "This level no longer exist.",
				"data" => []
			));

		}

	}
}
