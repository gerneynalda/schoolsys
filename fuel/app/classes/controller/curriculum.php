<?php
class Controller_Curriculum extends Controller_Template
{
	public function before()
	{
		parent::before();

		if(!Auth::check()) {

			Response::redirect('authenticate/login');
		}
		
		// add new asset path
		Asset::add_path("assets/fontawesome-free-6.5.2-web/css/", "css");
		Asset::add_path("assets/fontawesome-free-6.5.2-web/js/", "js");

		// load core styles and core scripts
		$this->template->set_global('core_styles', ['bootstrap.css', 'all.min.css', 'system-notification.css', 'core_styles.css']);
		$this->template->set_global('core_scripts', ['jquery-v.3.7.1.min.js', 'bootstrap.min.js', 'all.min.js', 'system-notifications.js', 'get-data-functions.js', 'create-data-functions.js', 'delete-data-functions.js', 'update-data-functions.js']);
	}

	public function action_index()
	{
		$data['curriculums'] = Model_Curriculum::find('all');
		$this->template->title = "Curriculums";
		$this->template->content = View::forge('curriculum/index', $data);

	}

	public function action_view($id = null)
	{
		is_null($id) and Response::redirect('curriculum');

		if ( ! $data['curriculum'] = Model_Curriculum::find($id))
		{
			Session::set_flash('error', 'Could not find curriculum #'.$id);
			Response::redirect('curriculum');
		}

		$this->template->title = "Curriculum";
		$this->template->content = View::forge('curriculum/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Curriculum::validate('create');

			if ($val->run())
			{
				$curriculum = Model_Curriculum::forge(array(
					'name' => Input::post('name'),
				));

				if ($curriculum and $curriculum->save())
				{
					Session::set_flash('success', 'Added curriculum #'.$curriculum->id.'.');

					Response::redirect('curriculum');
				}

				else
				{
					Session::set_flash('error', 'Could not save curriculum.');
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = "Curriculums";
		$this->template->content = View::forge('curriculum/create');

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('curriculum');

		if ( ! $curriculum = Model_Curriculum::find($id))
		{
			Session::set_flash('error', 'Could not find curriculum #'.$id);
			Response::redirect('curriculum');
		}

		$val = Model_Curriculum::validate('edit');

		if ($val->run())
		{
			$curriculum->name = Input::post('name');

			if ($curriculum->save())
			{
				Session::set_flash('success', 'Updated curriculum #' . $id);

				Response::redirect('curriculum');
			}

			else
			{
				Session::set_flash('error', 'Could not update curriculum #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$curriculum->name = $val->validated('name');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('curriculum', $curriculum, false);
		}

		$this->template->title = "Curriculums";
		$this->template->content = View::forge('curriculum/edit');

	}

	public function action_delete($id = null)
	{
		is_null($id) and Response::redirect('curriculum');

		if ($curriculum = Model_Curriculum::find($id))
		{
			$curriculum->delete();

			Session::set_flash('success', 'Deleted curriculum #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete curriculum #'.$id);
		}

		Response::redirect('curriculum');

	}

}
