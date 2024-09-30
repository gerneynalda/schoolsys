<?php
class Controller_Class extends Controller_Template
{

	public function action_index()
	{
		$data['classes'] = Model_Class::find('all');
		$this->template->title = "Classes";
		$this->template->content = View::forge('class/index', $data);

	}

	public function action_view($id = null)
	{
		is_null($id) and Response::redirect('class');

		if ( ! $data['class'] = Model_Class::find($id))
		{
			Session::set_flash('error', 'Could not find class #'.$id);
			Response::redirect('class');
		}

		$this->template->title = "Class";
		$this->template->content = View::forge('class/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Class::validate('create');

			if ($val->run())
			{
				$class = Model_Class::forge(array(
					'level_id' => Input::post('level_id'),
					'section_id' => Input::post('section_id'),
				));

				if ($class and $class->save())
				{
					Session::set_flash('success', 'Added class #'.$class->id.'.');

					Response::redirect('class');
				}

				else
				{
					Session::set_flash('error', 'Could not save class.');
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = "Classes";
		$this->template->content = View::forge('class/create');

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('class');

		if ( ! $class = Model_Class::find($id))
		{
			Session::set_flash('error', 'Could not find class #'.$id);
			Response::redirect('class');
		}

		$val = Model_Class::validate('edit');

		if ($val->run())
		{
			$class->level_id = Input::post('level_id');
			$class->section_id = Input::post('section_id');

			if ($class->save())
			{
				Session::set_flash('success', 'Updated class #' . $id);

				Response::redirect('class');
			}

			else
			{
				Session::set_flash('error', 'Could not update class #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$class->level_id = $val->validated('level_id');
				$class->section_id = $val->validated('section_id');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('class', $class, false);
		}

		$this->template->title = "Classes";
		$this->template->content = View::forge('class/edit');

	}

	public function action_delete($id = null)
	{
		is_null($id) and Response::redirect('class');

		if ($class = Model_Class::find($id))
		{
			$class->delete();

			Session::set_flash('success', 'Deleted class #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete class #'.$id);
		}

		Response::redirect('class');

	}

}
