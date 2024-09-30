<?php

namespace Fuel\Migrations;

class Create_curriculumsubjects
{
	public function up()
	{
		\DBUtil::create_table('curriculumsubjects', array(
			'id' => array('type' => 'int', 'unsigned' => true, 'null' => false, 'auto_increment' => true, 'constraint' => 11),
			'curriculum_id' => array('constraint' => 11, 'null' => false, 'type' => 'int'),
			'strand_id' => array('constraint' => 11, 'null' => false, 'type' => 'int'),
			'semester_id' => array('constraint' => 11, 'null' => false, 'type' => 'int'),
			'subject_id' => array('constraint' => 11, 'null' => false, 'type' => 'int'),
			'created_at' => array('constraint' => 11, 'null' => true, 'type' => 'int', 'unsigned' => true),
			'updated_at' => array('constraint' => 11, 'null' => true, 'type' => 'int', 'unsigned' => true),
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('curriculumsubjects');
	}
}