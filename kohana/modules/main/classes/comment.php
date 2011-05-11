<?php defined('SYSPATH') or die('No direct script access.');

class Comment {

	static function humanize_count ($count) {
		$humanized = false;

		if ($count > 0) {
			$ends_with = $count % 10;

			switch ($ends_with) {
			case 1:
				$humanized = $count.' komentar';
				break;

			default:
				$humanized = $count.' komentara';
			}
		} else {
			$humanized = 'nema komentara';
		}


		return $humanized;
	}

}
