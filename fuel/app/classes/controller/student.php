<?php
class Controller_Student extends Controller_Template
{
	public function before()
	{
		parent::before();
		// add new asset path
		Asset::add_path("assets/fontawesome-free-6.5.2-web/css/", "css");
		Asset::add_path("assets/fontawesome-free-6.5.2-web/js/", "js");

		// load core styles and core scripts
		$this->template->set_global('core_styles', ['bootstrap.css', 'all.min.css', 'system-notification.css', 'core_styles.css']);
		$this->template->set_global('core_scripts', ['jquery-v.3.7.1.min.js', 'bootstrap.min.js', 'all.min.js', 'system-notifications.js', 'get-data-functions.js', 'create-data-functions.js', 'delete-data-functions.js', 'update-data-functions.js']);
	}

	public function action_index()
	{
		$data['students'] = Model_Student::find('all');

		$customMenu = '<form class="navbar-form navbar-left" role="search">
			<a href="'.Config::get('base_url').'student/create" class="btn btn-primary btn-sm"><i class="fa-solid fa-plus"></i> Add Student</a>
		</form>';


		$this->template->set('customMenu', $customMenu, false);
		
		$this->template->set_global('scripts', ['student.js']);
		$this->template->title = "Students";
		$this->template->content = View::forge('student/index', $data);

	}

	public function action_view($id = null)
	{	
		$this->template->set_global('styles', ['student-view.css']);

		is_null($id) and Response::redirect('student');

		if ( ! $data['student'] = Model_Student::find($id))
		{
			Session::set_flash('error', 'Could not find student #'.$id);
			Response::redirect('student');
		}

		$this->template->set_global('scripts', ['student.js']);

		$this->template->title = "Student";
		$this->template->content = View::forge('student/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Student::validate('create');

			if ($val->run())
			{
				$student = Model_Student::forge(array(
					'lrn' => trim(Input::post('lrn')),
					'lastname' => trim(Input::post('lastname')),
					'firstname' => trim(Input::post('firstname')),
					'middlename' => trim(Input::post('middlename')),
					'suffix' => trim(Input::post('suffix')),
				));

				if ($student and $student->save())
				{
					Session::set_flash('success', 'Added student #'.$student->id.'.');

					Response::redirect('student/create');
				}

				else
				{
					Session::set_flash('error', 'Could not save student.');
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		// 
		$customMenu = '<form class="navbar-form navbar-right" role="search">
			<a class="btn btn-primary btn-sm" href="'.Config::get('base_url').'/student/index" >Find Students</a> 
			</form>';
		$this->template->set('customMenu', $customMenu, false);

		$this->template->set_global('scripts', ['student.js']);

		$this->template->title = "Students";
		$this->template->content = View::forge('student/create');

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('student');

		if ( ! $student = Model_Student::find($id))
		{
			Session::set_flash('error', 'Could not find student #'.$id);
			Response::redirect('student');
		}

		$val = Model_Student::validate('edit');

		if ($val->run())
		{
			$student->lrn = trim(Input::post('lrn'));
			$student->lastname = trim(Input::post('lastname'));
			$student->firstname = trim(Input::post('firstname'));
			$student->middlename = trim(Input::post('middlename'));
			$student->suffix = trim(Input::post('suffix'));

			if ($student->save())
			{
				Session::set_flash('success', 'Student information has been updated.');

				Response::redirect('student/edit/'.$id);
			}

			else
			{
				Session::set_flash('error', 'Could not update student #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$student->lrn = $val->validated('lrn');
				$student->lastname = $val->validated('lastname');
				$student->firstname = $val->validated('firstname');
				$student->middlename = $val->validated('middlename');
				$student->suffix = $val->validated('suffix');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('student', $student, false);
		}

		$this->template->title = "Students";
		$this->template->content = View::forge('student/edit');

	}

	public function action_delete($id = null)
	{
		is_null($id) and Response::redirect('student');

		if ($student = Model_Student::find($id))
		{
			$student->delete();

			Session::set_flash('success', 'Deleted student #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete student #'.$id);
		}

		Response::redirect('student');

	}

}
