<?php
use Orm\Model;

class Model_Student extends Model
{
	protected static $_properties = array(
		'id',
		'lrn',
		'lastname',
		'firstname',
		'middlename',
		'suffix',
		'created_at',
		'updated_at',
	);

	protected static $_observers = array(
		'Orm\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
			'mysql_timestamp' => false,
		),
		'Orm\Observer_UpdatedAt' => array(
			'events' => array('before_save'),
			'mysql_timestamp' => false,
		),
	);

	public static function validate($factory)
	{
		$val = Validation::forge($factory);
		$val->add_field('lrn', 'Lrn', 'required|max_length[250]');
		$val->add_field('lastname', 'Lastname', 'required|max_length[150]');
		$val->add_field('firstname', 'Firstname', 'required|max_length[150]');
		$val->add_field('middlename', 'Middlename', 'required|max_length[150]');
		$val->add_field('suffix', 'Suffix', 'max_length[50]');

		return $val;
	}

}
