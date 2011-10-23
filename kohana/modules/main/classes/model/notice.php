<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Notice extends ORM {

	protected $_has_many = array(
		'categories' => array('model' => 'category', 'through' => 'categories_notices'),
		'comments' => array(),
	);

	protected $_belongs_to = array(
		'user' => array()
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
			'title' => array(
				array('not_empty'),
				array('max_length', array(':value', 255)),
			),
			'content' => array(
				array('not_empty'),
				array('max_length', array(':value', 5000)),
			),
			'url_text' => array(
				array('not_empty'),
				array('max_length', array(':value', 70)),
			),
		);
	}

	public function filters() {
		return array(
			'title' => array(
				array('UTF8::trim'),
				array('Security::xss_clean')
			),
			'content' => array(
				array('UTF8::trim'),
				array('Security::xss_clean')
			)
		);
	}

}
