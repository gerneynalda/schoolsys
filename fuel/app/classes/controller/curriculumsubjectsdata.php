<?php

class Controller_Curriculumsubjectsdata extends Controller_Rest
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
        $curriculum_id = Input::get("curriculumid");
        $strand_id = Input::get("strandid");

        $sql = "SELECT * FROM `curriculumsubjects` WHERE `curriculum_id` = ".$curriculum_id." AND `strand_id` = ".$strand_id;
        $result = DB::query($sql)->as_object("Model_Curriculumsubject")->execute();

        return $this->response(array(
            "success" => true,
            "message" => "Listing curriculum subjects",
            "data"  => $result
        ));
    }

    public function get_curriculumsemester()
    {
        $curriculum_id = Input::get("curriculumid");
        $strand_id = Input::get("strandid");

        $sql = "SELECT DISTINCT `semester_id` FROM `curriculumsubjects` WHERE `curriculum_id` = ".$curriculum_id." AND `strand_id` = ".$strand_id;
        $result = DB::query($sql)->as_object("Model_Curriculumsubject")->execute();

        return $this->response(array(
            "success" => true,
            "message" => "Listing curriculum semeters",
            "data"  => $result
        ));
    }

    public function post_add()
    {

        $subjects = Input::json('subjects');
        $curriculum_id = Input::json("curriculumid");
        $strand_id = Input::json("strandid");
        
        $formattedSubjects = [];
        $timestamp = time();
        foreach($subjects as $subject) {
            $formattedSubjects[] = "(".$subject["curriculum_id"].", ".$subject["strand_id"].", ".$subject['semester_id'].", ".$subject["subject_id"].", ".$timestamp.", ".$timestamp.")";
        }

        $values = implode(", ", $formattedSubjects);

        $sql = "INSERT INTO `curriculumsubjects` (curriculum_id, strand_id, semester_id, subject_id, created_at, updated_at) VALUES ".$values;
        $result = DB::query($sql)->as_object("Model_Curriculumsubject")->execute();

        if($result) {

            return $this->response(array(
                "success"   => true,
                "message"   => "Subjects has been save to this curriculum",
                "data"      => $result
            ));

        }else {

            return $this->response(array(
                "success"   => false,
                "message"   => "Something went wrong, unable to save subjects to this curriculum",
                "data"      => []
            ));
            
        }

    }

    public function delete_remove()
    {
        
        $curriculumid = Input::get("curriculumid");
        $strandid = Input::get("strandid");
        $semesterid = Input::get("semesterid");
        $subjectid = Input::get("subjectid");

        $sql = "DELETE FROM `curriculumsubjects` WHERE `curriculum_id`=".$curriculumid." AND `strand_id`=".$strandid." AND `semester_id`=".$semesterid." AND `subject_id`=".$subjectid;
        $result = DB::query($sql)->as_object("Model_Curriculumsubject")->execute();

        if($result) {
			return $this->response(array(
				"success" => true,
				"message" => "Subject has been removed from the curriculum.",
				"data"	=> []
			));
		}else{
			return $this->response(array(
				"success" => false,
				"message" => "Something went wrong, unable to remove subject from the curriculum.",
				"data"	=> []
			));
		}
    }
}