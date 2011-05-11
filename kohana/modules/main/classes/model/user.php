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
				array(array($this, 'email_available'), array(':validation', ':field')),
			),
			'name' => array(
				array('not_empty'),
				array('min_length', array(':value', 2)),
				array('max_length', array(':value', 80)),
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
		);
	}

	public static function get_password_validation ($values) {
		return Validation::factory($values)
			->rule('password', 'min_length', array(':value', 5))
			->rule('password_confirm', 'matches', array(':validation', ':field', 'password'));
	}

}
