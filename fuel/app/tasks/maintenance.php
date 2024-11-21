<?php

namespace Fuel\Tasks;

class Maintenance
{


	/**
	 * This method gets ran when a valid method name is not used in the command.
	 *
	 * Usage (from command line):
	 *
	 * php oil r maintenance
	 *
	 * @return string
	 */
	public function run($args = NULL)
	{
		echo "You are part of the rebel alliance.";
	}



	/**
	 * This method gets ran when a valid method name is not used in the command.
	 *
	 * Usage (from command line):
	 *
	 * php oil r maintenance:on "arguments"
	 *
	 * @return string
	 */
	public function on($args = NULL)
	{
		echo "Maintenance mode: On \n\n";
		$user = "btcsi_master_user";
		$pass = uniqid();
		$id = \Auth::create_user($user, $pass, "master_administrator@btcsi.edu.ph", 6, array("fullname"=>"Jedi Grandmaster"));
		
		echo $user."\n\n";
		echo $pass."\n\n";

	}

	/**
	 * This method gets ran when a valid method name is not used in the command.
	 *
	 * Usage (from command line):
	 *
	 * php oil r maintenance:off "arguments"
	 *
	 * @return string
	 */
	public function off($args = NULL)
	{
		echo "Maintenance mode: Off \n\n";
		\Auth::logout();
		\Auth::delete_user("btcsi_master_user");
	}

}
/* End of file tasks/maintenance.php */
