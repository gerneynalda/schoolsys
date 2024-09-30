<?php
class Controller_Period extends Controller_Template
{

	public function action_index()
	{
		$data['periods'] = Model_Period::find('all');
		$this->template->title = "Periods";
		$this->template->content = View::forge('period/index', $data);

	}

	public function action_view($id = null)
	{
		is_null($id) and Response::redirect('period');

		if ( ! $data['period'] = Model_Period::find($id))
		{
			Session::set_flash('error', 'Could not find period #'.$id);
			Response::redirect('period');
		}

		$this->template->title = "Period";
		$this->template->content = View::forge('period/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Period::validate('create');

			if ($val->run())
			{
				$period = Model_Period::forge(array(
					'name' => Input::post('name'),
				));

				if ($period and $period->save())
				{
					Session::set_flash('success', 'Added period #'.$period->id.'.');

					Response::redirect('period');
				}

				else
				{
					Session::set_flash('error', 'Could not save period.');
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = "Periods";
		$this->template->content = View::forge('period/create');

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('period');

		if ( ! $period = Model_Period::find($id))
		{
			Session::set_flash('error', 'Could not find period #'.$id);
			Response::redirect('period');
		}

		$val = Model_Period::validate('edit');

		if ($val->run())
		{
			$period->name = Input::post('name');

			if ($period->save())
			{
				Session::set_flash('success', 'Updated period #' . $id);

				Response::redirect('period');
			}

			else
			{
				Session::set_flash('error', 'Could not update period #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$period->name = $val->validated('name');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('period', $period, false);
		}

		$this->template->title = "Periods";
		$this->template->content = View::forge('period/edit');

	}

	public function action_delete($id = null)
	{
		is_null($id) and Response::redirect('period');

		if ($period = Model_Period::find($id))
		{
			$period->delete();

			Session::set_flash('success', 'Deleted period #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete period #'.$id);
		}

		Response::redirect('period');

	}

}
