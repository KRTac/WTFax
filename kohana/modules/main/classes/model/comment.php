<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Comment extends ORM {

	protected $_belongs_to = array(
		'user' => array(),
		'notice' => array(),
	);

	protected $_created_column = array(
		'column' => 'created',
		'format' => true
	);

	public function rules() {
		return array(
			'display' => array(
				array('not_empty'),
				array('range', array(':value', 0, 1)),
			),
			'content' => array(
				array('not_empty'),
				array('max_length', array(':value', 2000)),
			),
		);
	}

	public function filters() {
		return array(
			'content' => array(
				array('UTF8::trim'),
				array('Security::xss_clean')
			)
		);
	}

}
