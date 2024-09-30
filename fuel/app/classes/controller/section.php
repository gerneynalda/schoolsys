<?php
class Controller_Section extends Controller_Template
{

	public function action_index()
	{
		$data['sections'] = Model_Section::find('all');
		$this->template->title = "Sections";
		$this->template->content = View::forge('section/index', $data);

	}

	public function action_view($id = null)
	{
		is_null($id) and Response::redirect('section');

		if ( ! $data['section'] = Model_Section::find($id))
		{
			Session::set_flash('error', 'Could not find section #'.$id);
			Response::redirect('section');
		}

		$this->template->title = "Section";
		$this->template->content = View::forge('section/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Section::validate('create');

			if ($val->run())
			{
				$section = Model_Section::forge(array(
					'name' => Input::post('name'),
				));

				if ($section and $section->save())
				{
					Session::set_flash('success', 'Added section #'.$section->id.'.');

					Response::redirect('section');
				}

				else
				{
					Session::set_flash('error', 'Could not save section.');
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = "Sections";
		$this->template->content = View::forge('section/create');

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('section');

		if ( ! $section = Model_Section::find($id))
		{
			Session::set_flash('error', 'Could not find section #'.$id);
			Response::redirect('section');
		}

		$val = Model_Section::validate('edit');

		if ($val->run())
		{
			$section->name = Input::post('name');

			if ($section->save())
			{
				Session::set_flash('success', 'Updated section #' . $id);

				Response::redirect('section');
			}

			else
			{
				Session::set_flash('error', 'Could not update section #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$section->name = $val->validated('name');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('section', $section, false);
		}

		$this->template->title = "Sections";
		$this->template->content = View::forge('section/edit');

	}

	public function action_delete($id = null)
	{
		is_null($id) and Response::redirect('section');

		if ($section = Model_Section::find($id))
		{
			$section->delete();

			Session::set_flash('success', 'Deleted section #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete section #'.$id);
		}

		Response::redirect('section');

	}

}
