<?php
class Controller_Schoolyear extends Controller_Template
{

	public function action_index()
	{
		$data['schoolyears'] = Model_Schoolyear::find('all');
		$this->template->title = "Schoolyears";
		$this->template->content = View::forge('schoolyear/index', $data);

	}

	public function action_view($id = null)
	{
		is_null($id) and Response::redirect('schoolyear');

		if ( ! $data['schoolyear'] = Model_Schoolyear::find($id))
		{
			Session::set_flash('error', 'Could not find schoolyear #'.$id);
			Response::redirect('schoolyear');
		}

		$this->template->title = "Schoolyear";
		$this->template->content = View::forge('schoolyear/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Schoolyear::validate('create');

			if ($val->run())
			{
				$schoolyear = Model_Schoolyear::forge(array(
					'name' => Input::post('name'),
				));

				if ($schoolyear and $schoolyear->save())
				{
					Session::set_flash('success', 'Added schoolyear #'.$schoolyear->id.'.');

					Response::redirect('schoolyear');
				}

				else
				{
					Session::set_flash('error', 'Could not save schoolyear.');
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = "Schoolyears";
		$this->template->content = View::forge('schoolyear/create');

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('schoolyear');

		if ( ! $schoolyear = Model_Schoolyear::find($id))
		{
			Session::set_flash('error', 'Could not find schoolyear #'.$id);
			Response::redirect('schoolyear');
		}

		$val = Model_Schoolyear::validate('edit');

		if ($val->run())
		{
			$schoolyear->name = Input::post('name');

			if ($schoolyear->save())
			{
				Session::set_flash('success', 'Updated schoolyear #' . $id);

				Response::redirect('schoolyear');
			}

			else
			{
				Session::set_flash('error', 'Could not update schoolyear #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$schoolyear->name = $val->validated('name');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('schoolyear', $schoolyear, false);
		}

		$this->template->title = "Schoolyears";
		$this->template->content = View::forge('schoolyear/edit');

	}

	public function action_delete($id = null)
	{
		is_null($id) and Response::redirect('schoolyear');

		if ($schoolyear = Model_Schoolyear::find($id))
		{
			$schoolyear->delete();

			Session::set_flash('success', 'Deleted schoolyear #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete schoolyear #'.$id);
		}

		Response::redirect('schoolyear');

	}

}
