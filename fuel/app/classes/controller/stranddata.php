<?php

Class Controller_Stranddata extends Controller_Rest
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
		$strand = Model_Strand::find("all");
		return $this->response(array(
			"message"	=> "Listing all strand.",
			"data"	=> $strand
		));
	}

	public function post_create()
	{

		$name = Input::json("name");

		$create = Model_Strand::forge(array(
			"name" => $name,
			'description' => ''
		));

		if($create->save()) {

			$this->response(array(
				"success" => true,
				"message" => "New strand has been created.",
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
        $id = Input::json('strandid');
		$name = Input::json('name');
	
		$strand = Model_Strand::find($id);
	
		if($strand) {

			$strand->name = $name;

			if($strand->save()) {

				return $this->response(array(
					"success" => true,
					"message" => "Strand name has been updated.",
					"data" => $strand
				));

			}else {
				
				return $this->response(array(
					"success" => false,
					"message" => "Something went wrong, unable to update strand name.",
					"data" => $strand
				));

			}

		}else {

			return $this->response(array(
				"success" => false,
				"message" => "This strand no longer exist.",
				"data" => []
			));

		}
    }

	public function delete_delete()
	{
		$strandid = Input::get("strandid");

		$sql = "DELETE FROM `strands` WHERE `id`=".$strandid;
		$result = DB::query($sql)->as_object("Model_Strand")->execute();

		if($result) {
			return $this->response(array(
				"success" => true,
				"message" => "Strand has been deleted.",
				"data"	=> []
			));
		}else{
			return $this->response(array(
				"success" => false,
				"message" => "Something went wrong, unable to delete strand.",
				"data"	=> []
			));
		}
		
	}
}