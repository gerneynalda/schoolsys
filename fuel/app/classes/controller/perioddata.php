<?php

Class Controller_Perioddata extends Controller_Rest
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
		$period = Model_Period::find("all");
		return $this->response(array(
			"message"	=> "Listing all period.",
			"data"	=> $period
		));
	}

	public function post_create()
	{

		$name = Input::json("name");

		$create = Model_Period::forge(array(
			"name" => $name
		));

		if($create->save()) {

			$this->response(array(
				"success" => true,
				"message" => "New Period has been created.",
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
        $id = Input::json('periodid');
		$name = Input::json('name');
	
		$period = Model_Period::find($id);
	
		if($period) {

			$period->name = $name;

			if($period->save()) {

				return $this->response(array(
					"success" => true,
					"message" => "Period name has been updated.",
					"data" => $period
				));

			}else {
				
				return $this->response(array(
					"success" => false,
					"message" => "Something went wrong, unable to update period name.",
					"data" => $period
				));

			}

		}else {

			return $this->response(array(
				"success" => false,
				"message" => "This period no longer exist.",
				"data" => []
			));

		}
    }

	public function delete_delete()
	{
		$periodid = Input::get("periodid");

		$sql = "DELETE FROM `periods` WHERE `id`=".$periodid;
		$result = DB::query($sql)->as_object("Model_Period")->execute();

		if($result) {
			return $this->response(array(
				"success" => true,
				"message" => "Period has been deleted.",
				"data"	=> []
			));
		}else{
			return $this->response(array(
				"success" => false,
				"message" => "Something went wrong, unable to delete period.",
				"data"	=> []
			));
		}
		
	}
}