<?php

namespace Fuel\Migrations;

class Add_strand_id_to_reportcardconfigurations
{
	public function up()
	{
		\DBUtil::add_fields('reportcardconfigurations', array(
			'strand_id' => array('constraint' => '11', 'null' => false, 'type' => 'int'),
		));
	}

	public function down()
	{
		\DBUtil::drop_fields('reportcardconfigurations', array(
			'strand_id'
		));
	}
}