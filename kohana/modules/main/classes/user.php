<?php defined('SYSPATH') or die('No direct script access.');

class User {

	static function send_email_confirmation ($user) {
		$config = Kohana::config('common');

		$headers = 'From: '.$config['email']['noreply']."\r\n";
		$message = View::factory('email/email_confirmation', array('user' => $user));

		return mail($user->email, $config['title']['default'].' - Potvrda email adrese', $message, $headers);
	}

	static function password_reset_email ($user) {
		$config = Kohana::config('common');

		$headers = 'From: '.$config['email']['noreply']."\r\n";
		$message = View::factory('email/reset_password', array('user' => $user));

		return mail($user->email, $config['title']['default'].' - Reset lozinke', $message, $headers);
	}

}
