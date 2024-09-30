<?php
class Controller_Subject extends Controller_Template
{

	public function action_index()
	{
		$data['subjects'] = Model_Subject::find('all');
		$this->template->title = "Subjects";
		$this->template->content = View::forge('subject/index', $data);

	}

	public function action_view($id = null)
	{
		is_null($id) and Response::redirect('subject');

		if ( ! $data['subject'] = Model_Subject::find($id))
		{
			Session::set_flash('error', 'Could not find subject #'.$id);
			Response::redirect('subject');
		}

		$this->template->title = "Subject";
		$this->template->content = View::forge('subject/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Subject::validate('create');

			if ($val->run())
			{
				$subject = Model_Subject::forge(array(
					'name' => Input::post('name'),
				));

				if ($subject and $subject->save())
				{
					Session::set_flash('success', 'Added subject #'.$subject->id.'.');

					Response::redirect('subject');
				}

				else
				{
					Session::set_flash('error', 'Could not save subject.');
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = "Subjects";
		$this->template->content = View::forge('subject/create');

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('subject');

		if ( ! $subject = Model_Subject::find($id))
		{
			Session::set_flash('error', 'Could not find subject #'.$id);
			Response::redirect('subject');
		}

		$val = Model_Subject::validate('edit');

		if ($val->run())
		{
			$subject->name = Input::post('name');

			if ($subject->save())
			{
				Session::set_flash('success', 'Updated subject #' . $id);

				Response::redirect('subject');
			}

			else
			{
				Session::set_flash('error', 'Could not update subject #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$subject->name = $val->validated('name');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('subject', $subject, false);
		}

		$this->template->title = "Subjects";
		$this->template->content = View::forge('subject/edit');

	}

	public function action_delete($id = null)
	{
		is_null($id) and Response::redirect('subject');

		if ($subject = Model_Subject::find($id))
		{
			$subject->delete();

			Session::set_flash('success', 'Deleted subject #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete subject #'.$id);
		}

		Response::redirect('subject');

	}

}
