<?php defined('SYSPATH') or die('No direct script access.');

class Random {

	static function hash ($restrictLength = 32) {
		$result = '';
		$charPool = '0123456789abcdefghijklmnopqrstuvwxyz';
		for ($p = 0, $l = strlen($charPool); $p < 10; $p++) {
			$result .= $charPool[mt_rand(0, $l - 1)];
		}

		return substr(sha1(md5(sha1($result))), 0, $restrictLength);
	}

}
