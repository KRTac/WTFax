<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_User extends Model_Auth_User {

	protected $_has_many = array(
		'user_tokens' => array('model' => 'user_token'),
		'roles'       => array('model' => 'role', 'through' => 'roles_users'),
		'categories'  => array('model' => 'category', 'through' => 'categories_users'),
		'comments' => array(),
	);

	protected $_created_column = array('column' => 'registration_time', 'format' => true);

	public function rules() {
		return array(
			'password' => array(
				array('not_empty'),
			),
			'email' => array(
				array('not_empty'),
				array('min_length', array(':value', 4)),
				array('max_length', array(':value', 127)),
				array('email'),
				array(array($this, 'unique'), array('email', ':value')),
			),
			'name' => array(
				array('not_empty'),
				array('min_length', array(':value', 2)),
				array('max_length', array(':value', 80)),
			),
			'notices_per_page' => array(
				array('not_empty'),
				array('range', array(':value', 10, 25)),
			),
		);
	}

	public function filters() {
		return array(
			'password' => array(
				array(array(Auth::instance(), 'hash'))
			),
			'name' => array(
				array('UTF8::trim'),
				array('HTML::chars')
			)
		);
	}

	public function labels() {
		return array(
			'email'            => 'Email',
			'password'         => 'Lozinka',
			'password_confirm' => 'Potvrda lozinke',
			'name' => 'Puno ime',
			'notices_per_page' => 'Broj obavijesti po stranici',
		);
	}

	public static function get_password_validation ($values) {
		return Validation::factory($values)
			->rule('password', 'min_length', array(':value', 5))
			->rule('password_confirm', 'matches', array(':validation', ':field', 'password'));
	}

}
