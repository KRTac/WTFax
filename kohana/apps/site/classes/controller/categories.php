<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Categories extends Controller_Base {

	public function action_initialize () {
		if (!isset($_GET['ok']) || $_GET['ok'] != 'ko') {
			echo 'Abort';
			return;
		}

		$root = ORM::factory('category');
		$root->name = 'Obavijesti veleučilišta';
		$root->description = '';
		$root->display = 1;
		$root->make_root();

			$multimedija = ORM::factory('category');
			$multimedija->name = 'Obavijesti studija multimedije';
			$multimedija->description = '';
			$multimedija->display = 1;
			$multimedija->insert_as_last_child($root);

				$prva = ORM::factory('category');
				$prva->name = '1. godina multimedije';
				$prva->description = '';
				$prva->display = 1;
				$prva->insert_as_last_child($multimedija);

					$mat1 = ORM::factory('category');
					$mat1->name = 'Matematika 1';
					$mat1->description = '';
					$mat1->display = 1;
					$mat1->insert_as_last_child($prva);

					$fiz1 = ORM::factory('category');
					$fiz1->name = 'Fizika 1';
					$fiz1->description = '';
					$fiz1->display = 1;
					$fiz1->insert_as_last_child($prva);

					$it = ORM::factory('category');
					$it->name = 'IT i primjena ';
					$it->description = '';
					$it->display = 1;
					$it->insert_as_last_child($prva);
	}

}
