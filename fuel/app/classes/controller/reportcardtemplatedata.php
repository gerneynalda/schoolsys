<?php

class Controller_Reportcardtemplatedata extends Controller_Rest
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

        $result = Model_Reportcardtemplate::find("all");
        return $this->response([
            "success"   => true,
            "message"   => "Listing all report card template.",
            "data"      => $result
        ]);

    }

    public function get_configuration()
    {

        $curriculum_id = Input::get('curriculumid');
        $strand_id = Input::get('strandid');

        $sql = "SELECT * FROM `reportcardtemplates` WHERE `curriculum_id`=".$curriculum_id." AND `strand_id`=".$strand_id;
        $result = DB::query($sql)->as_Object('Model_Reportcardtemplate')->execute();
        
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
        $id = Input::json('reportcardtemplateid');
        $curriculum_id = Input::json('curriculumid');
        $strand_id = Input::json('strandid');
        $configuration = Input::json('configuration');

        $sql = "SELECT * FROM `reportcardtemplates` WHERE `id`=".$id;
        $result = DB::query($sql)->as_Object('Model_Reportcardtemplate')->execute();

        $configuration_record = "";

        if(count($result) > 0) {
            // Operation: Update if result yields and existing record.
            $configuration_record = $result[0];
            $configuration_record->configuration = $configuration;
            $configuration_record->curriculum_id = $curriculum_id;
            $configuration_record->strand_id = $strand_id;

        }else {

            $configuration_record =  Model_Reportcardtemplate::forge([
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

    public function post_add()
    {

        if(isset($_FILES['file'])) {

            // allowed_extension
            $allowed_ext = ['xlsx'];

            // only xlsx are allowed
            $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

            if(in_array($extension, $allowed_ext)) {

                // directory path
                $dpath = DOCROOT."/files/report_card_templates/";

                // before saving file to destination check if a file with the same filename exist
                if(file_exists($dpath.$_FILES['file']['name'])) {
                    // if it exists
                    return $this->response([
                        "success"   => false,
                        "message"   => "A report card template with the same filename already exist.",
                        "data"      => []
                    ]);
                }

                // if there no duplicates; save file to destination
                $success = move_uploaded_file($_FILES['file']['tmp_name'], $dpath.$_FILES['file']['name']);

                if($success) {

                    // save the filename and filepath of the file to the database
                    $reportcard = Model_Reportcardtemplate::forge([
                        "filename"  => $_FILES['file']['name'],
                        "filepath"  => $dpath.$_FILES['file']['name']
                    ]);

                    if($reportcard->save()) {
                        // uploaded to directory and save to database
                        return $this->response([
                            "success"   => true,
                            "message"   => "Report card template was successfully uploaded.",
                            "data"      => []
                        ]);

                    }else {

                        // if was uploaded and not save to the database delete the file.
                        unlink($dpath.$_FILES['file']['name']);
                        return $this->response([
                            "success"   => true,
                            "message"   => "Something went wrong, file was uploaded but unable to store file information in the database.",
                            "data"      => []
                        ]);

                    }
                    

                }else{

                    return $this->response([
                        "success"   => false,
                        "message"   => "Something went wrong, unable to save file.",
                        "data"      => []
                    ]);

                }
                

            }else {

                // file not supported
                return $this->response([
                    "success"   => false,
                    "message"   => "This file type is not supported, only xlsx files are allowed.",
                    "data"      => []
                ]);

            }

        }else {

            // no file selected
            return $this->response([
                "success"   => false,
                "message"   => "Please select a file.",
                "data"      => []
            ]);

        }

    }

    public function delete_delete()
    {
        $id = Input::get("id");
        $template = Model_Reportcardtemplate::find($id);
        $name = $template->filename;
        $file = $template->filepath;

        if($template->delete()) {

            // after deleting file information in the database, delete the file
           if(unlink($file)) {

                return $this->response([
                    "success"   => true,
                    "message"   => "Report card template has been deleted.",
                    "data"      => []
                ]);

           }else {

                return $this->response([
                    "success"   => false,
                    "message"   => "Something went wrong, unable to delete file.",
                    "data"      => []
                ]);

           }

        } else {

            return $this->response([
                "success"   => false,
                "message"   => "Something went wrong, unable to delete file.",
                "data"      => []
            ]);

        }
    }
}