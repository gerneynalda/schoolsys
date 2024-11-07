<?php

class Controller_Subjectgradesdata extends Controller_Rest
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

    public function get_classgrades()
    {
        $schoolyear_id = Input::get("schoolyear_id");
        $class_id = Input::get("class_id");
        $curriculum_id = Input::get("curriculum_id");
        $strand_id = Input::get("strand_id");
        $semester_id = Input::get("semester_id");
        $period_id = Input::get("period_id");

        $sql = "SELECT * FROM `subjectgrades` WHERE `schoolyear_id`=".$schoolyear_id." AND `class_id`=".$class_id." AND `curriculum_id`=".$curriculum_id." AND `strand_id`=".$strand_id;
        $result = DB::query($sql)->as_object("Model_Subjectgrade")->execute();

        if($result) {
            
            return $this->response(array(
                "success"   => true,
                "message"   => "Listing all grades for this class.",
                "data"      => $result
            ));
        }else {

            return $this->response(array(
                "success"   => false,
                "message"   => "Something went wrong, unable to get the list of grades for this class.",
                "data"      => []
            ));

        }
    }

    public function get_studentgrade()
    {
        $lrn = Input::get("lrn");
        $schoolyear_id = Input::get("schoolyearid");
        $semester_id = Input::get("semesterid");
        $period_id = Input::get("periodid");
        $subject_id = Input::get("subjectid");

        $sql = "SELECT * FROM `subjectgrades` WHERE `lrn`=".$lrn." AND `semester_id`=".$semester_id." AND `period_id`=".$period_id." AND `subject_id`=".$subject_id;
        $result = DB::query($sql)->as_object("Model_Subjectgrade")->execute();

        if(count($result) > 0) {
            
            return $this->response(array(
                "success"   => true,
                "message"   => "Retrieving student's subject grades.",
                "data"      => $result
            ));

        }else {

            return $this->response(array(
                "success"   => true,
                "message"   => "Retrieving student's subject grades.",
                "data"      => []
            ));

        }

    }

    public function post_studentgrades()
    {
        $lrn = Input::json("lrn");
        $schoolyear_id = Input::json("schoolyearid");
        $semester_id = Input::json("semesterid");
        $period_id = Input::json("periodid");
        $subject_ids = Input::json("subjectids");

        $subjectArr = implode(",", $subject_ids);

        $sql = "SELECT * FROM `subjectgrades` WHERE `subject_id` IN (".$subjectArr.") AND `lrn`=".$lrn." AND `schoolyear_id`=".$schoolyear_id." AND `semester_id`=".$semester_id." AND `period_id`=".$period_id;
        $result = DB::query($sql)->execute()->as_array("subject_id");

        if(count($result) > 0) {

            return $this->response(array(
                "success"   => true,
                "message"   => "Getting student grade for this subject.",
                "data"      => $result
            ));

        } else {

            return $this->response(array(
                "success"   => true,
                "message"   => "Getting student grade for this subject.",
                "data"      => $result
            ));

        }

    }

    public function post_add()
    {
        $lrn = Input::json("lrn");
        $schoolyear_id = Input::json("schoolyearid");
        $semester_id = Input::json("semesterid");
        $period_id = Input::json("periodid");
        $subject_id = Input::json("subjectid");
        $curriculum_id = Input::json("curriculumid");
        $strand_id = Input::json("strandid");
        $class_id = Input::json("classid");
        $grade = Input::json("grade");

        // check
        $subjectgrade = $this->checkIfRecordExist($lrn, $schoolyear_id, $class_id, $curriculum_id, $strand_id, $semester_id, $period_id, $subject_id);

        if(!is_null($subjectgrade)) {

            $subjectgrade->grade = $grade;

        }else{

            $subjectgrade = Model_Subjectgrade::forge([
                "lrn" => $lrn,
                "schoolyear_id" => $schoolyear_id,
                "class_id"  => $class_id,
                "curriculum_id" => $curriculum_id,
                "strand_id"     => $strand_id,
                "semester_id"   => $semester_id,
                "period_id"     => $period_id,
                "subject_id"    => $subject_id,
                "grade"     => $grade
            ]);

        }
        
        if($subjectgrade->save()) {
            $this->response(array(
				"success" => true,
				"message" => "Saved.",
				"data" => $subjectgrade
			));
        }else{
            $this->response(array(
				"success" => false,
				"message" => "Something went wrong, unable to save data.",
				"data" => []
			));
        }
    }

    private function checkIfRecordExist($lrn, $schoolyearid, $classid, $curriculumid, $strandid, $semesterid, $periodid, $subjectid)
    {

        $sql = "SELECT * FROM `subjectgrades` WHERE `lrn`=".$lrn." AND `schoolyear_id`=".$schoolyearid;
        $sql .= " AND `class_id`=".$classid." AND `curriculum_id`=".$curriculumid." AND `strand_id`=".$strandid;
        $sql .= " AND `semester_id`=".$semesterid." AND `period_id`=".$periodid." AND `subject_id`=".$subjectid;

        $query = DB::query($sql)->as_object("Model_Subjectgrade")->execute();

        return count($query) > 0 ? $query[0] : null;
    }
}