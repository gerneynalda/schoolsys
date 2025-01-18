<?php

namespace Fuel\Migrations;

class Create_schoolyearmonthlyattendances
{
	public function up()
	{
		\DBUtil::create_table('schoolyearmonthlyattendances', array(
			'id' => array('type' => 'int', 'unsigned' => true, 'null' => false, 'auto_increment' => true, 'constraint' => 11),
			'lrn' => array('constraint' => 250, 'null' => false, 'type' => 'varchar'),
			'schoolyear_id' => array('constraint' => 11, 'null' => false, 'type' => 'int'),
			'schooldays_id' => array('constraint' => 11, 'null' => false, 'type' => 'int'),
			'days_present' => array('constraint' => 10, 'null' => true, 'type' => 'varcher'),
			'days_tardy' => array('constraint' => 10, 'null' => true, 'type' => 'varchar'),
			'created_at' => array('constraint' => 11, 'null' => true, 'type' => 'int', 'unsigned' => true),
			'updated_at' => array('constraint' => 11, 'null' => true, 'type' => 'int', 'unsigned' => true),
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('schoolyearmonthlyattendances');
	}
}