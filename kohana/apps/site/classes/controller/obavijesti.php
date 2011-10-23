<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Obavijesti extends Controller_Base {

	public function before () {
		parent::before();

		if ($this->request->action() == 'default') {
			if ($this->user) {
				$this->request->action('moje');
			} else {
				$this->request->action('sve');
			}
		}
	}

	public function action_sve () {
		$this->titles[] = 'Sve obavijesti';
		$this->active_menu_item = 'all';

		$total_notices = ORM::factory('notice')
			->where('display', '=', 1)
			->count_all();

		$pagination = Pagination::factory(array(
				'total_items' => $total_notices,
				'items_per_page' => $this->user->notices_per_page,
			))
			->route_params(array(
				'action' => 'sve',
				'controller' => 'obavijesti',
			));

		$notices = ORM::factory('notice')
			->where('display', '=', 1)
			->order_by('created', 'DESC')
			->offset($pagination->offset)
			->limit($pagination->items_per_page)
			->find_all();

		$this->content = View::factory('notices/container')
			->set('content', View::factory('notices', array(
				'notices' => $notices
			)))
			->set('pagination', $pagination);
	}

	public function action_moje () {
		if (!$this->user) {
			$this->content = View::factory('notices/must_login');
			return;
		}

		$this->titles[] = 'Moje obavijesti';
		$this->active_menu_item = 'my';

		$categories = $this->user->categories
			->where('display', '=', 1)
			->find_all();

		if (!count($categories)) {
			$this->content = View::factory('notices/no_categories_selected');

			return;
		}

		$category_ids = array();

		$notices = ORM::factory('notice')
			->join('categories_notices')
			->on('categories_notices.notice_id', '=', 'notice.id')
			->where_open();

		$totalNotices = DB::select()
			->from('notices')
			->select(DB::expr('COUNT(DISTINCT notices.id) AS notice_count'))
			->join('categories_notices')
			->on('categories_notices.notice_id', '=', 'notices.id')
			->where_open();

		foreach ($categories as $cat) {
			$category_ids[] = $cat->id;
			$notices->or_where('categories_notices.category_id', '=', $cat->id);
			$totalNotices->or_where('categories_notices.category_id', '=', $cat->id);
		}

		$totalNotices = $totalNotices->where_close()
			->and_where('notices.display', '=', 1)
			->execute()
			->get('notice_count');

		$pagination = Pagination::factory(array(
				'total_items' => $totalNotices,
				'items_per_page' => $this->user->notices_per_page,
			))
			->route_params(array(
				'action' => 'moje',
				'controller' => 'obavijesti',
			));

		$notices = $notices
			->where_close()
			->and_where('notice.display', '=', 1)
			->order_by('created', 'DESC')
			->group_by('notice.id')
			->offset($pagination->offset)
			->limit($pagination->items_per_page)
			->find_all();

		$this->content = View::factory('notices/container')
			->set('content', View::factory('notices', array(
				'notices' => $notices
			)))
			->set('pagination', $pagination);
	}

	public function action_kategorija () {
		$id = $this->request->param('id', null);
		$category = ORM::factory('category', $id);

		if (!$category->loaded() || $category->display != 1) {
			throw new HTTP_Exception_404;
		}

		$title = 'Kategorija: '.$category->name;
		$this->titles[] = $title;

		$notices = $category->notices
			->where('display', '=', '1')
			->reset(false);

		$totalNotices = $notices
			->count_all();

		$pagination = Pagination::factory(array(
				'current_page' => array('source' => 'route', 'key' => 'page'),
				'total_items' => $totalNotices,
				'items_per_page' => $this->user->notices_per_page,
			))
			->route_params(array(
				'id' => $id,
				'action' => 'kategorija',
				'controller' => 'obavijesti',
			));

		$notices = $notices
			->order_by('created', 'DESC')
			->offset($pagination->offset)
			->limit($pagination->items_per_page)
			->find_all();

		$this->content = View::factory('notices/container', array(
				'content' => View::factory('notices', array(
					'notices' => $notices,
				)),
				'title' => $title,
				'pagination' => $pagination,
			));
	}

	public function action_dodaj () {
		$this->titles[] = 'Dodaj obavijest';

		if (!$this->user) {
			$this->content = View::factory('notices/add/must_login');

			return;
		}

		$notice = ORM::factory('notice');
		$input_errors = array();
		$selected_categories = array();

		if ($_POST) {
			$notice->values($_POST, array(
				'title',
				'content',
			));
			$notice->display = 1;
			$notice->user = $this->user;

			if (!empty($_POST['_categories'])) {
				$selected_categories = Category::filter_valid_ids($_POST['_categories']);
			}

			try {
				$notice->url_text = URL::title(Text::limit_chars($notice->title, 40, '', true), '_', true);

				if ($notice->url_text == '') {
					$notice->url_text = URL::title(Text::limit_chars($notice->title, 40, '', false), '_', true);
				}

				$extra_validation = Validation::factory(array('_categories' => $selected_categories))
					->rule('_categories', 'not_empty');
				$notice->create($extra_validation);

				foreach ($selected_categories as $cat) {
					$notice->add('categories', ORM::factory('category', array('id' => $cat)));
				}

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

		$this->content = View::factory('notices/add')
			->bind('notice', $notice)
			->bind('selected_categories', $selected_categories)
			->bind('input_errors', $input_errors);
	}

	public function action_obavijest () {
		$id = $this->request->param('id', null);
		$notice = ORM::factory('notice', $id);

		if (!$notice->loaded() || $notice->display != 1) {
			throw new HTTP_Exception_404;
		}

		if (!empty($notice->title)) {
			$this->titles[] = $notice->title;
		}

		$this->add_script('!tinymce_comment');

		$this->content = View::factory('notices/notice')
			->bind('notice', $notice)
			->bind('user', $this->user);
	}

	public function action_komentiraj () {
		$ajax = isset($_GET['ajax']) ? true : false;
		if ($ajax) {
			$this->auto_render = false;
		}

		if (!$this->user) {
			if ($ajax) {
				echo json_encode(array(
					'status' => 'error',
					'msg' => 'Morate se prijaviti da bi mogli pisati komentare.'
				));
			} else {
				//
			}

			return;
		}

		$id = $this->request->param('id', null);
		$notice = ORM::factory('notice', $id);

		if (!$notice->loaded() || $notice->display != 1) {
			if ($ajax) {
				echo json_encode(array(
					'status' => 'error',
					'msg' => 'Tražena obavijest ne postoji.'
				));
			} else {
				throw new HTTP_Exception_404;
			}

			return;
		}

		if (empty($_POST['content'])) {
			if ($ajax) {
				echo json_encode(array(
					'status' => 'error',
					'msg' => 'Niste ništa napisali.'
				));
			} else {
				$this->request->redirect('/obavijest/'.$id);
			}

			return;
		}

		$comment = ORM::factory('comment')
			->values($_POST, array(
				'content'
			));
		$comment->display = 1;
		$comment->notice = $notice;
		$comment->user = $this->user;

		try {
			$comment->create();

			if ($ajax) {
				echo json_encode(array(
					'status' => 'success',
					'html' => View::factory('notices/comment/box', array(
						'comment' => $comment,
						'user' => $this->user
					))->render()
				));

				return;
			}

			$this->request->response('/obavijest/'.$id.'#komentar'.$comment->id);
		} catch (ORM_Validation_Exception $e) {
			if ($ajax) {
				$msg = $e->errors('models');

				echo json_encode(array(
					'status' => 'error',
					'msg' => $msg['content']
				));

				return;
			}
		}

		$this->request->response('/obavijest/'.$id);
	}

}
