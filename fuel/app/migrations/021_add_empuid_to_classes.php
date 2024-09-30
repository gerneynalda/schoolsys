<?php

namespace Fuel\Migrations;

class Add_empuid_to_classes
{
	public function up()
	{
		\DBUtil::add_fields('classes', array(
			'empuid' => array('constraint' => 250, 'null' => false, 'type' => 'varchar'),
		));
	}

	public function down()
	{
		\DBUtil::drop_fields('classes', array(
			'empuid'
		));
	}
}