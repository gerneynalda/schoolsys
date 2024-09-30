<?php

namespace Fuel\Migrations;

class Create_reportcardconfigurations
{
	public function up()
	{
		\DBUtil::create_table('reportcardconfigurations', array(
			'id' => array('type' => 'int', 'unsigned' => true, 'null' => false, 'auto_increment' => true, 'constraint' => 11),
			'reportcardtemplate_id' => array('constraint' => 11, 'null' => false, 'type' => 'int'),
			'curriculum_id' => array('constraint' => 11, 'null' => false, 'type' => 'int'),
			'configuration' => array('null' => false, 'type' => 'text'),
			'created_at' => array('constraint' => 11, 'null' => true, 'type' => 'int', 'unsigned' => true),
			'updated_at' => array('constraint' => 11, 'null' => true, 'type' => 'int', 'unsigned' => true),
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('reportcardconfigurations');
	}
}