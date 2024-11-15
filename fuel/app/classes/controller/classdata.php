<?php

class Controller_Classdata extends Controller_Rest
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
		$classes = Model_Class::find("all");
		return $this->response(array(
			"message"	=> "Listing all class.",
			"data"	=> $classes
		));
	}

	public function post_create()
	{
		$level_id = Input::json("level_id");
		$section_id = Input::json("section_id");
		$adviser_id = Input::json("adviser_id");
		// check for duplicate
		$sql = "SELECT * FROM `classes` WHERE `section_id` = ".$section_id." AND `level_id` = ".$level_id;
		$result = DB::query($sql)->as_object("Model_Class")->execute();

		if(count($result) <= 0) {

			$created = Model_Class::forge(array(
				"level_id"		=> $level_id,
				"section_id"	=> $section_id,
				"empuid"		=> $adviser_id
			));
			
			$result = $created->save();
	
			if($result) {
				return $this->response(array(
					"success"	=> true,
					"message" => "New class has been create.",
					"data" => [
						"id" => $created->id
					]
				));
			}else {
				return $this->response(array(
					"success" => false,
					"message" => "Unable to save to the database.",
					"data" => []
				));
			}

		}else {

			return $this->response(array(
				"success"	=> false,
				"message" => "This level and section already exist.",
				"data" => []
			));

		}

	}

	public function delete_delete()
	{
		$classid = Input::get("classid");

		$sql = "DELETE FROM `classes` WHERE `id`=".$classid;
		$result = DB::query($sql)->as_object("Model_Class")->execute();

		if($result) {
			return $this->response(array(
				"success" => true,
				"message" => "Class has been deleted.",
				"data"	=> []
			));
		}else{
			return $this->response(array(
				"success" => false,
				"message" => "Something went wrong, unable to delete class.",
				"data"	=> []
			));
		}
	}

	public function put_save()
	{
		$classid = Input::json("class_id");
		$empuid = Input::json("empuid");

		$class = Model_Class::find($classid);

		if($class) {

			$class->empuid = $empuid;
			if($class->save()) {

				return $this->response([
					"success"	=> true,
					"message"	=> "Class adviser has been changed.",
					"data"		=> [$class]
				]);

			} else {

				return $this->response([
					"success"	=> false,
					"message"	=> "Something went wrong, unable to save new class adviser.",
					"data"		=> [$class]
				]);

			}

		} else {

			return $this->response([
				"success"	=> false,
				"message"	=> "Class does not exist.",
				"data"		=> []
			]);

		}
	}
}
