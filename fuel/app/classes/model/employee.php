<?php

class Model_Employee extends \Orm\Model
{
	protected static $_properties = array(
		"id" => array(
			"label" => "Id",
			"data_type" => "int",
		),
		"empuid" => array(
			"label" => "Empuid",
			"data_type" => "varchar",
		),
		"lastname" => array(
			"label" => "Lastname",
			"data_type" => "varchar",
		),
		"firstname" => array(
			"label" => "Firstname",
			"data_type" => "varchar",
		),
		"middlename" => array(
			"label" => "Middlename",
			"data_type" => "varchar",
		),
		"suffix" => array(
			"label" => "Suffix",
			"data_type" => "varchar",
		),
		"role" => array(
			"label" => "Role",
			"data_type" => "varchar",
		),
		"created_at" => array(
			"label" => "Created at",
			"data_type" => "int",
		),
		"updated_at" => array(
			"label" => "Updated at",
			"data_type" => "int",
		),
	);

	protected static $_observers = array(
		'Orm\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
			'property' => 'created_at',
			'mysql_timestamp' => false,
		),
		'Orm\Observer_UpdatedAt' => array(
			'events' => array('before_update'),
			'property' => 'updated_at',
			'mysql_timestamp' => false,
		),
	);

	protected static $_table_name = 'employees';

	protected static $_primary_key = array('id');

	protected static $_has_many = array(
	);

	protected static $_many_many = array(
	);

	protected static $_has_one = array(
	);

	protected static $_belongs_to = array(
	);

}
