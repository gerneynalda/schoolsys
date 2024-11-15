<?php

class Controller_Attendancedata extends Controller_Rest
{
    public function before()
    {
        parent::before();
        $this->response->set_header("Access-Control-Allow-Origin", '*');
        $this->response->set_header("Access-Control-Allow-Header", "AccountKey,x-requested-with, Content-Type, origin, authorization, accept, client-security-token, host, date, cookie, cookie2");
        $this->response->set_header("Access-Control-Max-Age", '60');
        $this->response->set_header("Access-Control-Allow-Methods", "GET, POST, PUT, DELETE, OPTIONS");
    }

    public function post_monthlyattendance()
    {
        $lrn = Input::json('lrn');
        $schoolyear_id = Input::json('schoolyear_id');
        $schoolday_ids = Input::json('schoolday_ids');
 
        $ids = implode(",", $schoolday_ids);
        
        $sql = "SELECT * FROM `schoolyearmonthlyattendances` WHERE `lrn`='".$lrn."' AND `schoolyear_id` = ".$schoolyear_id." AND `schooldays_id` IN (".$ids.")";
        $result = DB::query($sql)->execute()->as_array('schooldays_id');

        return $this->response([
            "success"   => true,
            "message"   => "",
            "data"      => $result
        ]);
    }

    public function post_save()
    {
        $id = Input::json('id');

        if(!is_null($id)) {

            $record = Model_Schoolyearmonthlyattendance::find($id);

            if(is_null($record)) {

                return $this->response([
                    "success"   => false,
                    "message"   => "No record exist with this id.",
                    "data"      => []
                ]);

            }

            $type = Input::json('type');
            $value = Input::json('value');

            $record->$type = $value;

            // save
            if($record->save()) {

                return $this->response([
                    "success"   => true,
                    "message"   => "Attendance information has been  updated.",
                    "data"      => $record
                ]);

            } else {

                return $this->response([
                    "success"   => false,
                    "message"   => "Something went wrong, unable to save data.",
                    "data"      => []
                ]);

            }

        } else {

            $lrn = Input::json('lrn');
            $schoolyear_id = Input::json('schoolyear_id');
            $schooldays_id = Input::json('schooldays_id');
            $type = Input::json('type');
            $value = Input::json('value');

            $record = Model_Schoolyearmonthlyattendance::forge();

            $record->lrn = $lrn;
            $record->schoolyear_id = $schoolyear_id;
            $record->schooldays_id = $schooldays_id;
            $record->$type = $value;

             // save
             if($record->save()) {

                return $this->response([
                    "success"   => true,
                    "message"   => "Attendance information has been  updated.",
                    "data"      => $record->id
                ]);

            } else {

                return $this->response([
                    "success"   => false,
                    "message"   => "Something went wrong, unable to save data.",
                    "data"      => []
                ]);

            }

        }
    }
}