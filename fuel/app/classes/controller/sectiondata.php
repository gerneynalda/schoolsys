<?php

class Controller_Sectiondata extends Controller_Rest
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
		$sections = Model_Section::find("all");

		return $this->response(array(
			"message" => "Listing all sections.",
			"data" => $sections
		));
	}

	public function post_add()
	{

		$name = Input::json("name");

		$create = Model_Section::forge(array(
			"name" => $name
		));

		if($create->save()) {

			$this->response(array(
				"success" => true,
				"message" => "New section has been created.",
				"data" => $create
			));

		}else {

			$this->response(array(
				"success" => false,
				"message" => "Something went wront=g, unable to save data.",
				"data" => []
			));

		}
	}

	public function put_edit()
	{
		$id = Input::json('sectionid');
		$name = Input::json('name');

		$section = Model_Section::find($id);

		if($section) {

			$section->name = $name;

			if($section->save()) {

				return $this->response(array(
					"success" => true,
					"message" => "Section information has been updated.",
					"data" => []
				));

			}else {
				
				return $this->response(array(
					"success" => false,
					"message" => "Something went wrong, unable to update section.",
					"data" => []
				));

			}

		}else {
			
			return $this->response(array(
				"success" => false,
				"message" => "This section no longer exists.",
				"data" => []
			));

		}
	}

	public function delete_delete()
	{
		$id = Input::get("sectionid");

		$sql = "DELETE FROM `sections` WHERE `id` = ".$id;
		$section = DB::query($sql)->as_object("Model_Section")->execute();

		// check if a record with this $id exists.
		if(!$section) {

			return $this->response(array(
				"success" => false,
				"message" => "This section no longer exist.",
				"data"	=> []
			));

		}

		if($section) {

			return $this->response(array(
				"success" => true,
				"message" => "Section has been deleted.",
				"data"	=> []
			));

		}else{

			return $this->response(array(
				"success" => false,
				"message" => "Something went wrong, unable to delete section.",
				"data"	=> []
			));

		}

	}
}
