<?php
class Controller_Level extends Controller_Template
{

	public function action_index()
	{
		$data['levels'] = Model_Level::find('all');
		$this->template->title = "Levels";
		$this->template->content = View::forge('level/index', $data);

	}

	public function action_view($id = null)
	{
		is_null($id) and Response::redirect('level');

		if ( ! $data['level'] = Model_Level::find($id))
		{
			Session::set_flash('error', 'Could not find level #'.$id);
			Response::redirect('level');
		}

		$this->template->title = "Level";
		$this->template->content = View::forge('level/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Level::validate('create');

			if ($val->run())
			{
				$level = Model_Level::forge(array(
					'name' => Input::post('name'),
				));

				if ($level and $level->save())
				{
					Session::set_flash('success', 'Added level #'.$level->id.'.');

					Response::redirect('level');
				}

				else
				{
					Session::set_flash('error', 'Could not save level.');
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = "Levels";
		$this->template->content = View::forge('level/create');

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('level');

		if ( ! $level = Model_Level::find($id))
		{
			Session::set_flash('error', 'Could not find level #'.$id);
			Response::redirect('level');
		}

		$val = Model_Level::validate('edit');

		if ($val->run())
		{
			$level->name = Input::post('name');

			if ($level->save())
			{
				Session::set_flash('success', 'Updated level #' . $id);

				Response::redirect('level');
			}

			else
			{
				Session::set_flash('error', 'Could not update level #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$level->name = $val->validated('name');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('level', $level, false);
		}

		$this->template->title = "Levels";
		$this->template->content = View::forge('level/edit');

	}

	public function action_delete($id = null)
	{
		is_null($id) and Response::redirect('level');

		if ($level = Model_Level::find($id))
		{
			$level->delete();

			Session::set_flash('success', 'Deleted level #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete level #'.$id);
		}

		Response::redirect('level');

	}

}
