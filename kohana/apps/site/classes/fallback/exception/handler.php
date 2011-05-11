<?php defined('SYSPATH') or die('No direct script access.');

class Fallback_Exception_Handler {

	public static function handle (Exception $e) {
		switch (get_class($e)) {
		case 'HTTP_Exception_404':
			echo Request::factory('error/404')
				->execute()
				->send_headers()
				->body();

			return true;

		default:
			return Kohana_Exception::handler($e);
		}
	}

}
