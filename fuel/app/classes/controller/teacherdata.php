<?php

class Controller_Teacherdata extends Controller_Rest
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
        $sql = "SELECT * FROM `employees` WHERE `role`='teacher'";
        $result = DB::query($sql)->as_object("Model_Employee")->execute();

        return $this->response([
            "success"   => true,
            "message"   => "Listing all teachers",
            "data"      => $result
        ]);
    }

    public function post_add()
    {
        $lastname = strtolower(trim(Input::json("lastname")));
        $firstname = strtolower(trim(Input::json("firstname")));
        $middlename = strtolower(trim(Input::json("middlename")));
        $suffix = strtolower(trim(Input::json("suffix")));

        // check for duplicate
        $sql = "SELECT * FROM `employees` WHERE `role`='teacher' AND `lastname`='".$lastname."' AND `firstname`='".$firstname."' AND `middlename`='".$middlename."' AND `suffix`='".$suffix."'";
        $result = DB::query($sql)->as_object("Model_Employee")->execute();
        
        if(count($result) > 0) {
            
            // update information
            return $this->response([
                "success"   => false,
                "message"   => "This teacher's information is already recorded in the database.",
                "data"      => []
            ]);

        } else {

            // create a unique employee id
            $empuid = uniqid();

            $employee = Model_Employee::forge([
                "empuid"    => $empuid,
                "lastname"  => ucfirst($lastname),
                "firstname" => ucfirst($firstname),
                "middlename"   => ucfirst($middlename),
                "suffix"    => strtoupper($suffix),
                "role"      => "teacher"
            ]);

            if($employee->save()) {

                return $this->response([
                    "success"   => true,
                    "message"   => "Teacher ".$employee->lastname.", ".$employee->firstname." ".$employee->middlename." ".$employee->suffix." information was added to the database",
                    "data"      => [$employee]
                ]);

            } else {

                return $this->response([
                    "success"   => false,
                    "message"   => "Something went wrong, unable to save teachers information.",
                    "data"      => []
                ]);

            }

        }
    }

    public function put_save()
    {
        $id = Input::json('id');

        $lastname = strtolower(trim(Input::json('lastname')));
        $firstname = strtolower(trim(Input::json('firstname')));
        $middlename = strtolower(trim(Input::json('middlename')));
        $suffix = strtolower(trim( Input::json('suffix')));

        $employee = Model_Employee::find($id);

        if(!is_null($employee)) {

            $employee->lastname = ucfirst($lastname);
            $employee->firstname = ucfirst($firstname);
            $employee->middlename = ucfirst($middlename);
            $employee->suffix = ucfirst($suffix);

            if($employee->save()) {

                // successfull save
                return $this->response([
                    "success"   => true,
                    "message"   => "Teacher information has been saved.",
                    "data"  => [$employee]
                ]);

            } else {

                // unable to save
                return $this->response([
                    "success"   => false,
                    "message"   => "Something went wrong, unable to save data.",
                    "data"  => [$employee]
                ]);

            }

        }else {

            // employee does not exist
            return $this->response([
                "success"   => false,
                "message"   => "This teacher information does not exist in the database.",
                "data"  => []
            ]);
            
        }
    }

    public function delete_delete()
    {
        $id = Input::get("id");

        $employee = Model_Employee::find($id);
        
        if(!is_null($employee)) {

            if($employee->delete()) {

                return $this->response([
                    "success"   => true,
                    "message"   => "Teacher information has been deleted.",
                    "data"  => []
                ]);

            } else {

                return $this->response([
                    "success"   => false,
                    "message"   => "Something went wrong, unable to delete teacher information.",
                    "data"  => [$employee]
                ]);

            }

        } else {

            return $this->response([
                "success"   => false,
                "message"   => "Teacher information does not exist.",
                "data"  => []
            ]);

        }

    }
}