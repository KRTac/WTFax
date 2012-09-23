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

		case 'Notice_Not_Found':
			echo Request::factory('error/notice_not_found')
				->execute()
				->send_headers()
				->body();

			return true;

		case 'Action_Unauthorized':
			echo Request::factory('error/action_unauthorized')
				->execute()
				->send_headers()
				->body();

			return true;

		default:
			return Kohana_Exception::handler($e);
		}
	}

}
