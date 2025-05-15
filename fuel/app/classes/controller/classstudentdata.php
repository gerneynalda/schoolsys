<?php

class Controller_Classstudentdata extends Controller_Rest
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

	public function get_list() {

		$class_id = Input::get("classid");
		$schoolyear_id = Input::get("schoolyearid");
		// $filter = Input::get("filter");

		$sql = "SELECT `students`.`id`, `students`.`lrn`, `students`.`lastname`, `students`.`firstname`, `students`.`middlename`, `students`.`gender`, `students`.`suffix` FROM `students` 
		INNER JOIN `schoolyearclassstudents` ON `schoolyearclassstudents`.`lrn` = `students`.`lrn` 
		WHERE `schoolyearclassstudents`.`class_id` = {$class_id} AND `schoolyearclassstudents`.`schoolyear_id` =  {$schoolyear_id} 
		ORDER BY `students`.`gender` DESC, `students`.`lastname` ASC";

		$class_students = DB::query($sql)->as_object('Model_Student')->execute();

		return $this->response(array(
			"message" => "Display class students for this school year.",
			"data"	=> $class_students
		));

	}

	public function post_add()
	{
		$class_id = Input::json("class_id");
		$schoolyear_id = Input::json("schoolyear_id");
		$studentLrn = Input::json("lrn");
		$current_timestamp = time();

		// no duplicate lrn on a class_id and schoolyear_id
		$checkdata = implode(',',$studentLrn);
		// query if the lrn that was submitted has a record on the database with same class_id and schoolyear_id
		$sql = "SELECT `lrn` FROM `schoolyearclassstudents` WHERE `lrn` IN (".$checkdata.") AND `class_id`=".$class_id." AND `schoolyear_id`=".$schoolyear_id;
		// the result are lrn that already has a record.
		$inClassAlreadyLrn = DB::query($sql)->as_object("Model_Schoolyearclassstudent")->execute();
		$toRemoveLrn= [];
		foreach($inClassAlreadyLrn as $lrn){
			$toRemoveLrn[] = $lrn->lrn;
		}
		
		// if has duplicate
		if(count($toRemoveLrn) > 0) {

			foreach($toRemoveLrn as $lrn) {
				// get the index of the lrn from the studentLrn( an array of submitted lrn's )
				$index = array_search($lrn, $studentLrn);
				// then remove them.
				unset($studentLrn[$index]);
			}

		}
		
		if(count($studentLrn) > 0) {

			$lrns = [];
			foreach($studentLrn as $lrn ) {
				$lrns[] = '("'.$lrn.'",'.$class_id.','.$schoolyear_id.','.$current_timestamp.','.$current_timestamp.')';
			}

			$values = implode(",",$lrns);

			$sql = "INSERT INTO schoolyearclassstudents (lrn, class_id, schoolyear_id, created_at, updated_at) VALUES ".$values;
			$result = DB::query($sql)->execute();
			
			return $this->response(array(
				"success" => true, 
				"message" => $result[1]." students added to this class.",
				"data"	=> $result
			));

		}else {

			return $this->response(array(
				"success" => false,
				"message" => "",
				"data"	=> []
 			));

		}

	}

	public function delete_remove()
	{
		$class_id = Input::get("classid");
		$schoolyear_id = Input::get("schoolyearid");
		$lrn = Input::get("lrn");
		
		$sql = "DELETE FROM `schoolyearclassstudents` WHERE `lrn`=".$lrn." AND `class_id`=".$class_id." AND `schoolyear_id`=".$schoolyear_id;
		$student = DB::query($sql)->as_object("Model_Schoolyearclassstudent")->execute();

		if($student) {
			return $this->response(array(
				"success"	=> true,
				"message"	=> "Student remove from class.",
				"data"		=> []
			));

		}else {
			return $this->response(array(
				"success" => false,
				"message" => "Something went wrong, unable to remove student from class.",
				"data"	  => []
			));
		}

	}

}
