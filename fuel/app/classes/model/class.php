<?php
use Orm\Model;

class Model_Class extends Model
{
	protected static $_properties = array(
		'id',
		'level_id',
		'section_id',
		'empuid',
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
		$val->add_field('level_id', 'Level Id', 'required|valid_string[numeric]');
		$val->add_field('section_id', 'Section Id', 'required|valid_string[numeric]');

		return $val;
	}

}
