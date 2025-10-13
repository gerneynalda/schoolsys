<?php

class Controller_Studentdata extends Controller_Rest
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
        $students = Model_Student::find("all");

        return $this->response(array(
            "message" => "Listing all students.",
            "data"  => $students
        ));
    }

    // get student data base on the lrn
    public function post_listByLRN() {

        $lrns = Input::json('lrns'); 

        $lrns = implode(',', $lrns);

        $sql = "SELECT * FROM `students` WHERE `lrn` IN (".$lrns.")";
        $sql .= "ORDER BY `students`.`gender` DESC, `students`.`lastname` ASC, `students`.`firstname` ASC";
        $students = DB::query($sql)->as_object('Model_Student')->execute();

        // $students = DB::select()->from('students')->order_by('gender', 'DESC')->order_by('lastname', 'ASC')->order_by('firstname', 'ASC')->where('lrn', "in", $lrns)->as_object('Model_Student')->execute();

        return $this->response([
            "success"   => true,
            "message"   => "Listing students.",
            "data"      => $students
        ]);

    }
}