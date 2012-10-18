<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Obavijesti extends Controller_Admin_Base {

	public function action_brisi () {
		$notice = ORM::factory('notice', $this->request->param('param', ''));

		if ($notice->loaded())
			$notice->delete();

		$redirect_to = $_GET['redirect_to'] ? $_GET['redirect_to'] : '/';

		$this->request->redirect($redirect_to);
	}

	public function action_odobri () {
		$notice = ORM::factory('notice', $this->request->param('param', ''));

		if ($notice->loaded()) {
			$notice->display = 1;
			$notice->save();
		}

		$this->request->redirect('/obavijest/' . $notice->id . '/' . $notice->url_text);
	}

	public function action_sakrij () {
		$notice = ORM::factory('notice', $this->request->param('param', ''));

		if ($notice->loaded()) {
			$notice->display = 0;
			$notice->save();
		}

		$this->request->redirect('/obavijest/' . $notice->id . '/' . $notice->url_text);
	}

	public function action_uredi () {
		$notice = ORM::factory('notice', $this->request->param('param', ''));

		if (!$notice->loaded())
			$this->request->redirect('/');

		$this->titles[] = 'Uredi "'.$notice->title.'"';

		$input_errors = array();
		$selected_categories = array();

		$current_categories = $notice->categories
			->where('display', '=', 1)
			->find_all();

		foreach ($current_categories as $cat)
			$selected_categories[] = $cat->id;

		if ($_POST) {
			if (isset($_POST['display']))
				$_POST['display'] = 1;
			else
				$_POST['display'] = 0;

			$notice->values($_POST, array(
				'title',
				'content',
				'display',
			));

			if (!empty($_POST['_categories']))
				$selected_categories = Category::filter_valid_ids($_POST['_categories']);
			else
				$selected_categories = array();

			try {
				$notice->url_text = URL::title(Text::limit_chars($notice->title, 40, '', true), '_', true);

				if ($notice->url_text == '')
					$notice->url_text = URL::title(Text::limit_chars($notice->title, 40, '', false), '_', true);

				$extra_validation = Validation::factory(array('_categories' => $selected_categories))
					->rule('_categories', 'not_empty');

				$notice->update($extra_validation);

				DB::delete('categories_notices')->where('notice_id', '=', $notice->id)->execute();

				foreach ($selected_categories as $cat)
					$notice->add('categories', ORM::factory('category', array('id' => $cat)));

				$this->request->redirect('/obavijest/'.$notice->id);
			} catch (ORM_Validation_Exception $e) {
				$input_errors = $e->errors('models');

				if (isset($input_errors['_external'])) {
					$input_errors = array_merge($input_errors, $input_errors['_external']);
					unset($input_errors['_external']);
				}
			}
		}

		$this->add_script('!tinymce');

		$this->content = View::factory('notices/edit')
			->bind('notice', $notice)
			->bind('selected_categories', $selected_categories)
			->bind('input_errors', $input_errors);
	}

}
