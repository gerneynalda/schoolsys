<?php
class Controller_Semester extends Controller_Template
{

	public function action_index()
	{
		$data['semesters'] = Model_Semester::find('all');
		$this->template->title = "Semesters";
		$this->template->content = View::forge('semester/index', $data);

	}

	public function action_view($id = null)
	{
		is_null($id) and Response::redirect('semester');

		if ( ! $data['semester'] = Model_Semester::find($id))
		{
			Session::set_flash('error', 'Could not find semester #'.$id);
			Response::redirect('semester');
		}

		$this->template->title = "Semester";
		$this->template->content = View::forge('semester/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Semester::validate('create');

			if ($val->run())
			{
				$semester = Model_Semester::forge(array(
					'name' => Input::post('name'),
				));

				if ($semester and $semester->save())
				{
					Session::set_flash('success', 'Added semester #'.$semester->id.'.');

					Response::redirect('semester');
				}

				else
				{
					Session::set_flash('error', 'Could not save semester.');
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = "Semesters";
		$this->template->content = View::forge('semester/create');

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('semester');

		if ( ! $semester = Model_Semester::find($id))
		{
			Session::set_flash('error', 'Could not find semester #'.$id);
			Response::redirect('semester');
		}

		$val = Model_Semester::validate('edit');

		if ($val->run())
		{
			$semester->name = Input::post('name');

			if ($semester->save())
			{
				Session::set_flash('success', 'Updated semester #' . $id);

				Response::redirect('semester');
			}

			else
			{
				Session::set_flash('error', 'Could not update semester #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$semester->name = $val->validated('name');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('semester', $semester, false);
		}

		$this->template->title = "Semesters";
		$this->template->content = View::forge('semester/edit');

	}

	public function action_delete($id = null)
	{
		is_null($id) and Response::redirect('semester');

		if ($semester = Model_Semester::find($id))
		{
			$semester->delete();

			Session::set_flash('success', 'Deleted semester #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete semester #'.$id);
		}

		Response::redirect('semester');

	}

}
