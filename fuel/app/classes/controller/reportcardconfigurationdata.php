<?php

class Controller_Reportcardconfigurationdata extends Controller_Rest
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

    public function get_configuration()
    {

        $reportcardtemplate_id = Input::get('reportcardtemplateid');
        $curriculum_id = Input::get('curriculumid');
        $strand_id = Input::get('strandid');

        $sql = "SELECT * FROM `reportcardconfigurations` WHERE `reportcardtemplate_id`=".$reportcardtemplate_id." AND `curriculum_id`=".$curriculum_id." AND `strand_id`=".$strand_id;
        $result = DB::query($sql)->as_Object('Model_Reportcardconfiguration')->execute();
        
        if(count($result) > 0) {

            return $this->response([
                "success"   => true,
                "message"   => "Retrieving report card template configuration.",
                "data"      => $result[0]
            ]);

        }else {

            return $this->response([
                "success"   => true,
                "message"   => "This report card template is not configured yet.",
                "data"      => []
            ]);

        }

    }

    public function post_save()
    {

        $reportcardtemplate_id = Input::json('reportcardtemplateid');
        $curriculum_id = Input::json('curriculumid');
        $strand_id = Input::json('strandid');
        $configuration = Input::json('configuration');

        $sql = "SELECT * FROM `reportcardconfigurations` WHERE `reportcardtemplate_id`=".$reportcardtemplate_id." AND `curriculum_id`=".$curriculum_id." AND `strand_id`=".$strand_id;
        $result = DB::query($sql)->as_Object('Model_Reportcardconfiguration')->execute();

        $configuration_record = "";

        if(count($result) > 0) {
            // Operation: Update if result yields and existing record.
            $configuration_record = $result[0];
            $configuration_record->configuration = $configuration;

        }else {

            $configuration_record =  Model_Reportcardconfiguration::forge([
                'reportcardtemplate_id' => $reportcardtemplate_id,
                'curriculum_id' => $curriculum_id,
                'strand_id' => $strand_id,
                'configuration' => $configuration
            ]);

        }

        // save the data
        if($configuration_record->save()) {
            
            return $this->response([
                'success'   => true,
                'message'   => 'Report card configuration has been saved.',
                'data'      => []
            ]);

        } else {
            
            return $this->response([
                'success'   => false,
                'message'   => 'Something went wrong, unable to save configuration.',
                'data'      => []
            ]);

        }

    }
}