<?php

namespace Fuel\Migrations;

class Add_configuration_to_reportcardtemplates
{
	public function up()
	{
		\DBUtil::add_fields('reportcardtemplates', array(
			'configuration' => array('null' => false, 'type' => 'text'),
		));
	}

	public function down()
	{
		\DBUtil::drop_fields('reportcardtemplates', array(
			'configuration'
		));
	}
}