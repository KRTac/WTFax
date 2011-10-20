<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Category extends ORM_MPTT {

	protected $_has_many = array(
		'notices' => array('model' => 'notice', 'through' => 'categories_notices'),
		'users' => array('model' => 'user', 'through' => 'categories_users'),
	);

	public function rules() {
		return array(
			'display' => array(
				array('not_empty'),
				array('range', array(':value', 0, 1)),
			),
			'name' => array(
				array('not_empty'),
				array('max_length', array(':value', 80)),
			),
		);
	}

	public function labels() {
		return array(
			'description' => '',
			'name' => 'Ime kategorije',
		);
	}

	public function parents_string() {
		$parents = $this->parents(true);
		$string = false;
		foreach ($parents as $v) {
			$string .= $v->name.' → ';
		}

		return $string.$this->name;
	}

	public static function render_tree($node = null, $displayMatters = false, $htmlClass = null, $htmlId = null, $selectedCategories = array()) {
		if (!isset($node)) {
			$node = ORM::factory('category');

			$root = $node->roots();
		} else {
			if (!($node instanceof Model_Category)) {
				$node = ORM::factory('category', $node);
			}

			if (!$node->loaded()) {
				return false;
			}

			$root = $node->children();
		}

		$output = '<ul'.(!empty($htmlId)
			? ' id="'.$htmlId.'"'
			: '').(!empty($htmlClass)
			? ' class="'.$htmlClass.'"'
			: '').'>';

		foreach ($root as $branch) {
			if ($displayMatters && $branch->display != 1) {
				continue;
			}
			$hasChildren = $branch->has_children();

			$output .= '<li>'.($hasChildren ? '<a class="toggle_child_list" href="#"></a>' : '').'<input type="checkbox"'.(in_array($branch->id, $selectedCategories) ? ' checked="checked"' : '').' name="_categories[]" value="'.$branch->id.'" id="inputCategory'.$branch->id.'" /><label for="inputCategory'.$branch->id.'">'.$branch->name.'</label>';

			if ($hasChildren) {
				$output .= Model_Category::render_tree($branch, $displayMatters, null, null, $selectedCategories);
			}

			$output .= '</li>';
		}

		return $output.'</ul>';
	}

}
