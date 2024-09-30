<?php

class Controller_Curriculumtraitsdata extends Controller_Rest
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

        $sql = "SELECT * FROM `curriculumtraits` WHERE `curriculum_id` = ".$curriculum_id." AND `strand_id` = ".$strand_id;
        $result = DB::query($sql)->as_object("Model_Curriculumtrait")->execute();

        return $this->response(array(
            "success" => true,
            "message" => "Listing curriculum traits",
            "data"  => $result
        ));
    }

    public function post_create()
    {

        $traits = Input::json('traits');
        $curriculum_id = Input::json("curriculumid");
        $strand_id = Input::json("strandid");

        // get the traits of this curriculum
        $sql = "SELECT * FROM `curriculumtraits` WHERE `curriculum_id` = ".$curriculum_id." AND `strand_id` = ".$strand_id;
        $result = DB::query($sql)->as_object("Model_Curriculumtrait")->execute();
        $curriculum_traits = [];
        
        foreach($result as $curriculum_trait) {
            $curriculum_traits[] = $curriculum_trait->curriculum_id."_".$curriculum_trait->strand_id."_".$curriculum_trait->semester_id."_".$curriculum_trait->trait_id;
        }
        
        $formattedTraits = [];
        $timestamp = time();
        foreach($traits as $trait) {
            // making sure no duplicate trait on a curriculum
            if(!in_array($trait["curriculum_id"]."_".$trait["strand_id"]."_".$trait["semester_id"]."_".$trait["trait_id"], $curriculum_traits)) {
                $formattedTraits[] = "(".$trait["curriculum_id"].", ".$trait["strand_id"].", ".$trait['semester_id'].", ".$trait["trait_id"].", ".$timestamp.", ".$timestamp.")";
            }

        }

        $values = implode(", ", $formattedTraits);

        $sql = "INSERT INTO `curriculumtraits` (curriculum_id, strand_id, semester_id, trait_id, created_at, updated_at) VALUES ".$values;
        $result = DB::query($sql)->as_object("Model_Curriculumtrait")->execute();

        if($result) {

            return $this->response(array(
                "success"   => true,
                "message"   => "Traits has been added to this curriculum",
                "data"      => $result
            ));

        }else {

            return $this->response(array(
                "success"   => false,
                "message"   => "Something went wrong, unable to save traits to this curriculum",
                "data"      => []
            ));
            
        }

    }

    public function delete_delete()
    {
        $id = Input::get('id');

        $curriculum_trait = Model_Curriculumtrait::find($id);

        if(!is_null($curriculum_trait)) {

            if($curriculum_trait->delete()) {

                return $this->response([
                    "success"   => true,
                    "message"   => "Trait has been removed from curriculum.",
                    "data"  => []
                ]);

            } else {

                return $this->response([
                    "success"   => false,
                    "message"   => "Something went wrong unable to remove trait from the curriculum.",
                    "data"  => []
                ]);

            }

        } else {

            return $this->response([
                "success"   => false,
                "message"   => "This trait does not exist in this curriculum.",
                "data"  => []
            ]);

        }
    }
}