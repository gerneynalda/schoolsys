<?php

class Controller_Schooldaysdata extends Controller_Rest
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
        $schoolyear_id = Input::get('id');

        $sql = "SELECT * FROM `schoolyearschooldays` WHERE `schoolyear_id`=".$schoolyear_id;
        $result = DB::query($sql)->as_object('Model_Schoolyearschoolday')->execute();

        return $this->response([
            "success"   => true,
            "message"   => "Listing all school days in this school year",
            "data"      => $result
        ]);
    }

    public function post_create()
    {

        $schooldays = Input::json('schooldays');

        $formatted = [];
        $timestamp = time();

        foreach($schooldays as $schoolday) {

           $formatted[] = "(".$schoolday["schoolyear_id"].", '".$schoolday["month"]."', ".$schoolday["no_of_days"].", ".$timestamp.", ".$timestamp.")";

        }

        $values = implode(",", $formatted);
        $sql = "INSERT INTO `schoolyearschooldays` (`schoolyear_id`, `month`, `no_of_days`, `created_at`, `updated_at`) VALUES ".$values;
        $result = DB::query($sql)->as_object("Model_Schoolyearschoolday")->execute();

        return $this->response([
            "success"   => true,
            "message"   => "School year school days have been save.",
            "data"      => $result
        ]);

    }

    public function put_edit() 
    {
        $id = Input::json('id');
        $no_of_days = Input::json('no_of_days');

        if(empty($no_of_days)) {

            return $this->response([
                "success"   => false,
                "message"   => "Please input the number of days.",
                "data"      => []
            ]);

        }

        $record = Model_Schoolyearschoolday::find($id);

        if(!is_null($record)) {

            $record->no_of_days = $no_of_days;

            if($record->save()) {

                $this->response([
                    "success"   => true,
                    "message"   => "School days information successfully updated.",
                    "data"      => [$record]
                ]);

            } else {

                $this->response([
                    "success"   => false,
                    "message"   => "Something went wrong, unable to save data.",
                    "data"      => []

                ]);

            }

        } else {

            return $this->response([
                "success"   => false,
                "message"   => "Record does not exist.",
                "success"   => []
            ]);

        }


    }

    public function delete_delete()
    {
        $id = Input::get('id');

        $record = Model_Schoolyearschoolday::find($id);

        if(!is_null($record)) {

            if($record->delete()) {

                $this->response([
                    "success"   => true,
                    "message"   => "Record has been successfully delete.",
                    "data"      => []

                ]);

            } else {

                $this->response([
                    "success"   => false,
                    "message"   => "Something went wrong, unable to save data.",
                    "data"      => []

                ]);

            }

        } else {

            return $this->response([
                "success"   => false,
                "message"   => "Record does not exist.",
                "success"   => []
            ]);


        }
    }
}