<?php
class Controller_Strand extends Controller_Template
{

	public function action_index()
	{
		$data['strands'] = Model_Strand::find('all');
		$this->template->title = "Strands";
		$this->template->content = View::forge('strand/index', $data);

	}

	public function action_view($id = null)
	{
		is_null($id) and Response::redirect('strand');

		if ( ! $data['strand'] = Model_Strand::find($id))
		{
			Session::set_flash('error', 'Could not find strand #'.$id);
			Response::redirect('strand');
		}

		$this->template->title = "Strand";
		$this->template->content = View::forge('strand/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Strand::validate('create');

			if ($val->run())
			{
				$strand = Model_Strand::forge(array(
					'name' => Input::post('name'),
					'description' => Input::post('description'),
				));

				if ($strand and $strand->save())
				{
					Session::set_flash('success', 'Added strand #'.$strand->id.'.');

					Response::redirect('strand');
				}

				else
				{
					Session::set_flash('error', 'Could not save strand.');
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = "Strands";
		$this->template->content = View::forge('strand/create');

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('strand');

		if ( ! $strand = Model_Strand::find($id))
		{
			Session::set_flash('error', 'Could not find strand #'.$id);
			Response::redirect('strand');
		}

		$val = Model_Strand::validate('edit');

		if ($val->run())
		{
			$strand->name = Input::post('name');
			$strand->description = Input::post('description');

			if ($strand->save())
			{
				Session::set_flash('success', 'Updated strand #' . $id);

				Response::redirect('strand');
			}

			else
			{
				Session::set_flash('error', 'Could not update strand #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$strand->name = $val->validated('name');
				$strand->description = $val->validated('description');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('strand', $strand, false);
		}

		$this->template->title = "Strands";
		$this->template->content = View::forge('strand/edit');

	}

	public function action_delete($id = null)
	{
		is_null($id) and Response::redirect('strand');

		if ($strand = Model_Strand::find($id))
		{
			$strand->delete();

			Session::set_flash('success', 'Deleted strand #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete strand #'.$id);
		}

		Response::redirect('strand');

	}

}
