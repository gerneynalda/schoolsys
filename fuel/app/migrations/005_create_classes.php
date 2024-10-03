<?php

namespace Fuel\Migrations;

class Create_classes
{
	public function up()
	{
		\DBUtil::create_table('classes', array(
			'id' => array('type' => 'int', 'unsigned' => true, 'null' => false, 'auto_increment' => true, 'constraint' => '11'),
			'level_id' => array('constraint' => '11', 'null' => false, 'type' => 'int'),
			'section_id' => array('constraint' => '11', 'null' => false, 'type' => 'int'),
			'empuid' => array('constraint' => 250, 'null' => false, 'type' => 'varchar'),
			'created_at' => array('constraint' => '11', 'null' => false, 'type' => 'int'),
			'updated_at' => array('constraint' => '11', 'null' => false, 'type' => 'int'),
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('classes');
	}
}