<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Controller_Createreportcarddata extends Controller_Rest
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


    public function post_generatereportcard()
	{
		$schoolyear_id = Input::json("schoolyearid");
		$class_id = Input::json("classid");
		$curriculum_id = Input::json("curriculumid");
		$strand_id = Input::json("strandid");
		$lrns = Input::json("lrns");
        $LRNS = implode(",", $lrns);  // a string of lrns to be used for the where in clause, only this lrns will be retrieve from the database.

        // schoolyear
        $schoolyear = Model_Schoolyear::find($schoolyear_id);
        // class
        $class = Model_Class::find($class_id);
        // section
        $section = Model_Section::find($class->section_id);
        // level
        $level = Model_Level::find($class->level_id);
        // strand
        $strand = Model_Strand::find($strand_id);
        // teachers
        $sql = "SELECT * FROM `employees` WHERE `role`='teacher'";
        $teachers = DB::query($sql)->execute()->as_array('empuid');

        // get student details
        $sql = "SELECT * FROM `students` WHERE `lrn` IN (".$LRNS.")";
        $students = DB::query($sql)->execute()->as_array("lrn");

        // get reportcard template configuration
        $sql = "SELECT * FROM `reportcardtemplates` WHERE `curriculum_id`=".$curriculum_id." AND `strand_id`=".$strand_id;
        $reportcardtemplate = DB::query($sql)->as_object("Model_Reportcardtemplate")->execute();
        $configurations = json_decode($reportcardtemplate[0]->configuration);

        // get the subject grades of students(lrn) group by lrn on a given schoolyear, curriculum and strand id.
        $sql = "SELECT * FROM `subjectgrades` WHERE `lrn` IN (".$LRNS.") AND `schoolyear_id`=".$schoolyear_id." AND `curriculum_id`=".$curriculum_id." AND `strand_id`=".$strand_id;
        $subjectgrades = DB::query($sql)->as_object("Model_Subjectgrade")->execute();

        // get the trait grades of students(lrn) group by lrn on a given schoolyear, curriculum and strand id.
        $sql = "SELECT * FROM `traitgrades` WHERE `lrn` IN (".$LRNS.") AND `schoolyear_id`=".$schoolyear_id." AND `curriculum_id`=".$curriculum_id." AND `strand_id`=".$strand_id;
        $traitgrades = DB::query($sql)->as_object("Model_Traitgrade")->execute();

        // get students attendance
        $sql = "SELECT * FROM `schoolyearmonthlyattendances` WHERE `lrn` IN (".$LRNS.") AND `schoolyear_id`=".$schoolyear_id;
        $studentAttendance = DB::query($sql)->as_object("Model_Schoolyearmonthlyattendance")->execute();
        
        // add the lrns as key to subjects, traits, attendances.
        $subjectgradeArr = [];
        $traitgradeArr = [];
        $attendanceArr = [];

        // loop through lrn json; this are the selected lrns;
        // initialize their value as empty array;
        foreach($lrns as $lrn) {
            $subjectGradeArr[$lrn] = [];
            $traitgradeArr[$lrn] = [];
            $attendanceArr[$lrn] =[];
        }

        // fill in grades from subjects for each lrn; given the curriculum_id, strand_id, subject_id, semester_id, and period_id;
        foreach($subjectgrades as $item) {
           $subjectgradeArr[$item->lrn][$curriculum_id."_".$strand_id."_".$item->subject_id."_".$item->semester_id."_".$item->period_id] = $item->grade;
        }
        // fill in grades from traits for each lrn; given the curriculum_id, strand_id, trait_id, semester_id, and period_id;
        foreach($traitgrades as $item) {
            $traitgradeArr[$item->lrn][$curriculum_id."_".$strand_id."_".$item->trait_id."_".$item->semester_id."_".$item->period_id] = $item->grade;
        }
        // fil in the attendance for each lrn; given the schoolyear_id, and values of days_present and days_taryd
        foreach($studentAttendance as $attendance) {
            $attendanceArr[$attendance->lrn][$attendance->schoolyear_id."_".$attendance->schooldays_id."_days_present"] = $attendance->days_present;
            $attendanceArr[$attendance->lrn][$attendance->schoolyear_id."_".$attendance->schooldays_id."_days_tardy"] = $attendance->days_tardy;
        }

        // load the reportcard template
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load($reportcardtemplate[0]->filepath);

        // the loop through reportcard configuration while looping through students
        foreach($students as $key => $value) {
            $sheetIndex = 0;
            foreach($configurations as $sheet) {
                // per sheet
                // if a config have multiple sheet means it has multiple worksheet
                $clonedWorksheet = clone $spreadsheet->getSheet($sheetIndex);
                // [firstname][0] meanins the first character; same with middlename
                $firstname = is_null($value['firstname']) || (trim($value['firstname']) == "") ? "" : $value['firstname'][0]; 
                $middlename = is_null($value['middlename']) || (trim($value['middlename']) == "") ? "" : $value['middlename'][0];

                $clonedWorksheet->setTitle($value['lastname'].", ".$firstname." ".$middlename."_".$sheetIndex);
                
                // per config
                foreach($sheet as $config) {
                    switch($config->type) {
                        case "lrn":
                            $clonedWorksheet->setCellValue($config->cell_coordinate, $value["lrn"]);
                            break;
                        case "name":
                            $clonedWorksheet->setCellValue($config->cell_coordinate, $value['lastname'].", ".$value["firstname"]." ".$value["middlename"]." ".$value["suffix"]);
                            break;
                        case "adviser":
                            $clonedWorksheet->setCellValue($config->cell_coordinate, $teachers[$class->empuid]['lastname'].", ".$teachers[$class->empuid]['firstname']." ".$teachers[$class->empuid]['middlename']." ".$teachers[$class->empuid]['suffix']);
                            break;
                        case "level":
                            $clonedWorksheet->setCellValue($config->cell_coordinate, $level->name);
                            break;
                        case "section":
                            $clonedWorksheet->setCellValue($config->cell_coordinate, $section->name);
                            break;
                        case "schoolyear":
                            $clonedWorksheet->setCellValue($config->cell_coordinate, "SY:".$schoolyear->name);
                            break;
                        case "track":
                            $clonedWorksheet->setCellValue($config->cell_coordinate, $strand->name);
                            break;
                        case "subject":
                            // block of code for subject grades
                            $grade = "";
                            if(array_key_exists($value["lrn"], $subjectgradeArr)) {
                                $grade = array_key_exists($curriculum_id."_".$strand_id."_".$config->subject_id."_".$config->semester_id."_".$config->period_id, $subjectgradeArr[$value["lrn"]]) ? $subjectgradeArr[$value["lrn"]][$curriculum_id."_".$strand_id."_".$config->subject_id."_".$config->semester_id."_".$config->period_id] : "";
                            }
                            $clonedWorksheet->setCellValue($config->cell_coordinate, $grade);
                            break;
                        case "trait":
                            // block of code for trait grade
                            $grade = "";
                            if(array_key_exists($value["lrn"], $traitgradeArr)) {
                                $grade = array_key_exists($curriculum_id."_".$strand_id."_".$config->trait_id."_".$config->semester_id."_".$config->period_id, $traitgradeArr[$value["lrn"]]) ? $traitgradeArr[$value["lrn"]][$curriculum_id."_".$strand_id."_".$config->trait_id."_".$config->semester_id."_".$config->period_id] : "";
                            }
                            $clonedWorksheet->setCellValue($config->cell_coordinate, $grade);
                            break;
                        case "attendance":
                            $attendance = "";
                            if(array_key_exists($value["lrn"], $attendanceArr)){
                                $attendance = array_key_exists($config->schoolyear_id."_".$config->schooldays_id."_".$config->attendance_type, $attendanceArr[$value['lrn']]) ? $attendanceArr[$value["lrn"]][$config->schoolyear_id."_".$config->schooldays_id."_".$config->attendance_type] : "";
                            }
                            $clonedWorksheet->setCellValue($config->cell_coordinate, $attendance);
                            break;
                        default:
                            break;
                    }
                }

                // append
                $spreadsheet->addSheet($clonedWorksheet);   
                $sheetIndex++;
            }

        }
       
        // place to save
        $path = DOCROOT."files/report_cards/";
        // filename
        $filename = $schoolyear->name."_".$level->name." ".$section->name."_report cards.xlsx";
        // save to file
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save($path.$filename);
        // return public url
        $public_url = Config::get("base_url")."/files/report_cards/".$filename;

        return $this->response([
            "success"   => true,
            "message"   => "Successful",
            "data"      => [$public_url]
        ]);

	}
}