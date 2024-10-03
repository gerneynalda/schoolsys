<?php

namespace Fuel\Migrations;

class Create_employees
{
	public function up()
	{
		\DBUtil::create_table('employees', array(
			'id' => array('type' => 'int', 'unsigned' => true, 'null' => false, 'auto_increment' => true, 'constraint' => 11),
			'empuid' => array('constraint' => 250, 'null' => false, 'type' => 'varchar'),
			'lastname' => array('constraint' => 150, 'null' => false, 'type' => 'varchar'),
			'firstname' => array('constraint' => 150, 'null' => false, 'type' => 'varchar'),
			'middlename' => array('constraint' => 150, 'null' => false, 'type' => 'varchar'),
			'suffix' => array('constraint' => 50, 'null' => false, 'type' => 'varchar'),
			'role' => array('constraint' => 250, 'null' => false, 'type' => 'varchar'),
			'created_at' => array('constraint' => 11, 'null' => true, 'type' => 'int', 'unsigned' => true),
			'updated_at' => array('constraint' => 11, 'null' => true, 'type' => 'int', 'unsigned' => true),
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('employees');
	}
}