<?php

class Controller_Traitdata extends Controller_Rest
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
        $traits = Model_Trait::find("all");

        return $this->response([
            "success"   => true,
            "message"   => "Listing all traits.",
            "data"      => $traits
        ]);
    }

    public function post_save()
    {
        $description = trim(strtolower(Input::json('description')));

        if(empty($description)) {
            return $this->response([
                "success"   => false,
                "message"   => "Please fill out the description of this trait.",
                "data"      => []
            ]);
        }

        $trait = Model_Trait::forge([
            "description"   => ucfirst($description)
        ]);

        if($trait->save()) {

            return $this->response([
                "success"   => true,
                "message"   => "New trait has been added.",
                "data"      => [$trait]
            ]);

        } else {

            return $this->response([
                "success"   => false,
                "message"   => "Something went wrong, unable to save new trait.",
                "data"      => [$trait]
            ]);

        }
    }

    public function put_save()
    {
        $id = trim(Input::json('id'));
        $description = trim(strtolower(Input::json('description')));

        if(empty($id)) {

            return $this->response([
                "success"   => false,
                "message"   => "Something went wrong, unable to find that trait.",
                "data"      => ["id"=>$id]
            ]);

        }
        
        if(empty($description)) {

            return $this->response([
                "success"   => false,
                "message"   => "Please fill out the description of this trait.",
                "data"      => []
            ]);

        }

        $trait = Model_Trait::find($id);

        $trait->description = ucfirst($description);

        if($trait->save()) {
    
            return $this->response([
                "success"   => true,
                "message"   => "Trait information has been updated.",
                "data"      => [$trait]
            ]);

        } else {

            return $this->response([
                "success"   => false,
                "message"   => "Something went wrong, unable to save trait information.",
                "data"      => []
            ]);

        }
    }

    public function delete_delete()
    {
        $id = trim(Input::get('id'));

        if(empty($id)) {

            return $this->response([
                "success"   => false,
                "message"   => "Something went wrong, unable to find that trait.",
                "data"      => ["id"=>$id]
            ]);

        }

        $trait = Model_Trait::find($id);
        if($trait->delete()) {
    
            return $this->response([
                "success"   => true,
                "message"   => "Trait information has been deleted.",
                "data"      => [$trait]
            ]);

        } else {

            return $this->response([
                "success"   => false,
                "message"   => "Something went wrong, unable to delete trait information.",
                "data"      => []
            ]);

        }
    }
}