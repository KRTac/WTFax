<?php defined('SYSPATH') or die('No direct script access.');

class Category {

	static function filter_valid_ids ($ids, $display = false) {
		$valid_ids = array();

		if (!empty($ids) && is_array($ids)) {
			foreach ($ids as $id) {
				$cat = ORM::factory('category')
					->where('id', '=', $id);

				if ($display) {
					$cat->where('display', '=', 1);
				}
				$cat->find();

				if ($cat->loaded()) {
					$valid_ids[] = $id;
				}
			}
		}

		return $valid_ids;
	}

}
