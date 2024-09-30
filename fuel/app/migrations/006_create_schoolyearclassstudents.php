<?php

namespace Fuel\Migrations;

class Create_schoolyearclassstudents
{
	public function up()
	{
		\DBUtil::create_table('schoolyearclassstudents', array(
			'id' => array('type' => 'int', 'unsigned' => true, 'null' => false, 'auto_increment' => true, 'constraint' => '11'),
			'lrn' => array('constraint' => 250, 'null' => false, 'type' => 'varchar'),
			'class_id' => array('constraint' => '11', 'null' => false, 'type' => 'int'),
			'schoolyear_id' => array('constraint' => '11', 'null' => false, 'type' => 'int'),
			'created_at' => array('constraint' => '11', 'null' => false, 'type' => 'int'),
			'updated_at' => array('constraint' => '11', 'null' => false, 'type' => 'int'),
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('schoolyearclassstudents');
	}
}