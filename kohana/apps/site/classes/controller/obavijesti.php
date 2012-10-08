<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Obavijesti extends Controller_Base {

	public $rss_out;
	public $rss_items = array();
	public $rss_info = array();

	public function before () {
		parent::before();

		if ($this->request->action() == 'default') {
			if ($this->user) {
				$this->request->action('moje');
			} else {
				$this->request->action('sve');
			}
		}

		$this->rss_out = isset($_GET['rss']);
	}

	public function after () {
		if ($this->rss_out) {
			$this->auto_render = false;

			$this->request->response()->headers('Content-Type', 'application/rss+xml');

			$notices = array();

			foreach ($this->rss_items as $notice) {
				$notices[] = array(
					'title' => HTML::chars($notice->title),
					'description' => HTML::chars($notice->content),
					'link' => '/obavijest/'.$notice->id,
					'pubDate' => $notice->created,
					'guid' => '/obavijest/'.$notice->id
				);
			}

			echo Feed::create($this->rss_info, $notices);
		}

		parent::after();
	}

	public function action_sve () {
		$this->titles[] = 'Sve obavijesti';
		$this->active_menu_item = 'all';

		$notices = ORM::factory('notice');

		if (!$this->user_roles['admin']) {
			$notices->where('display', '=', 1);
		}

		$notices->reset(false);

		$total_notices = $notices->count_all();

		$pagination = Pagination::factory(array(
				'total_items' => $total_notices,
				'items_per_page' => $this->notices_per_page,
			))
			->route_params(array(
				'action' => 'sve',
				'controller' => 'obavijesti',
			));

		$notices = $notices->order_by('created', 'DESC')
			->offset($pagination->offset)
			->limit($pagination->items_per_page)
			->find_all();

		if ($this->rss_out) {
			$this->rss_items = $notices;
			$this->rss_info = array(
				'title' => 'Sve obavijesti veleučilišta',
				'description' => 'RSS feed za pračenje svih objavljenih obavijesti'
			);
		} else {
			$this->content = View::factory('notices/container')
				->set('content', View::factory('notices', array(
					'notices' => $notices,
					'user_roles' => $this->user_roles
				)))
				->set('pagination', $pagination->render());
		}
	}

	public function action_moje () {
		if (!$this->user) {
			$this->content = View::factory('notices/must_login');
			return;
		}

		$this->titles[] = 'Moje obavijesti';
		$this->active_menu_item = 'my';

		$categories = $this->user->categories;

		if (!$this->user_roles['admin']) {
			$categories->where('display', '=', 1);
		}

		$categories = $categories->find_all();

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

		$totalNotices->where_close();
		$notices->where_close();

		if (!$this->user_roles['admin']) {
			$totalNotices->and_where('notices.display', '=', 1);
			$notices->and_where('notice.display', '=', 1);
		}

		$totalNotices = $totalNotices->execute()
			->get('notice_count');

		$pagination = Pagination::factory(array(
				'total_items' => $totalNotices,
				'items_per_page' => $this->notices_per_page,
			))
			->route_params(array(
				'action' => 'moje',
				'controller' => 'obavijesti',
			));

		$notices = $notices->order_by('created', 'DESC')
			->group_by('notice.id')
			->offset($pagination->offset)
			->limit($pagination->items_per_page)
			->find_all();

		$this->content = View::factory('notices/container')
			->set('content', View::factory('notices', array(
				'notices' => $notices,
				'user_roles' => $this->user_roles
			)))
			->set('pagination', $pagination->render());
	}

	public function action_kategorija () {
		$id = $this->request->param('id', null);
		$category = ORM::factory('category', $id);

		if (!$category->loaded() || $category->display != 1) {
			throw new HTTP_Exception_404;
		}

		$title = 'Kategorija: '.$category->name;
		$this->titles[] = $title;

		$notices = $category->notices;

		if (!$this->user_roles['admin']) {
			$notices->where('display', '=', '1');
		}

		$notices->reset(false);

		$totalNotices = $notices
			->count_all();

		$pagination = Pagination::factory(array(
				'current_page' => array('source' => 'route', 'key' => 'page'),
				'total_items' => $totalNotices,
				'items_per_page' => $this->notices_per_page,
			))
			->route_params(array(
				'id' => $id,
				'action' => 'kategorija',
				'url_text' => $category->url_text,
				'controller' => 'obavijesti',
			));

		$notices = $notices
			->order_by('created', 'DESC')
			->offset($pagination->offset)
			->limit($pagination->items_per_page)
			->find_all();


		if ($this->rss_out) {
			$this->rss_items = $notices;
			$this->rss_info = array(
				'title' => 'Sve obavijesti kategorije '.$category->name,
				'description' => 'RSS feed za pračenje obavijesti iz kategorije '.$category->name
			);
		} else {
			$this->content = View::factory('notices/container', array(
					'content' => View::factory('notices', array(
						'notices' => $notices,
						'user_roles' => $this->user_roles
					)),
					'title' => $title,
					'pagination' => $pagination->render(),
				));
		}
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

				if ($notice->url_text == '')
					$notice->url_text = URL::title(Text::limit_chars($notice->title, 40, '', false), '_', true);

				$extra_validation = Validation::factory(array('_categories' => $selected_categories))
					->rule('_categories', 'not_empty');
				$notice->create($extra_validation);

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

		$this->content = View::factory('notices/add')
			->bind('notice', $notice)
			->bind('selected_categories', $selected_categories)
			->bind('input_errors', $input_errors);
	}

	public function action_obavijest () {
		$id = $this->request->param('id', null);
		$notice = ORM::factory('notice', $id);

		if (!$notice->loaded() || ($notice->display != 1 && !$this->user_roles['admin'])) {
			throw new Notice_Not_Found;
		}

		if (!empty($notice->title)) {
			$this->titles[] = $notice->title;
		}

		$this->add_script('!tinymce_comment');

		$this->content = View::factory('notices/notice')
			->bind('notice', $notice)
			->bind('user', $this->user)
			->bind('user_roles', $this->user_roles);
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
					'msg' => 'Morate se prijaviti da biste mogli pisati komentare.'
				));
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

	public function action_trazi () {
		if (!isset($_GET['q']))
			$this->request->redirect('/');

		$query = UTF8::trim($_GET['q']);
		$query_src = HTML::chars($query);

		if ($query == '')
			$this->request->response('/');

		$double_quote_count = mb_substr_count($query, '"');

		$query_bits = array();

		if ($double_quote_count > 0) {
			if ($double_quote_count % 2 == 1) {
				$last_doublequote_pos = UTF8::strrpos($query, '"');
				$query = UTF8::substr($query, 0, $last_doublequote_pos) . UTF8::substr($query, $last_doublequote_pos + 1);
			}

			$first_double_quote = UTF8::strpos($query, '"');
			$second_double_quote = UTF8::strpos($query, '"', $first_double_quote + 1);

			while ($first_double_quote !== false) {
				$segment = HTML::chars(UTF8::trim(UTF8::substr($query, $first_double_quote + 1, $second_double_quote - $first_double_quote - 1)));

				if (UTF8::strlen($segment) > 0)
					$query_bits[] = $segment;

				$query = UTF8::substr_replace($query, ' ', $first_double_quote, $second_double_quote - $first_double_quote + 1);

				$first_double_quote = UTF8::strpos($query, '"');
				$second_double_quote = UTF8::strpos($query, '"', $first_double_quote + 1);
			}
		}

		$query = HTML::chars(UTF8::trim($query));

		if (UTF8::strlen($query) > 0) {
			$space_position = UTF8::strpos($query, ' ');
			if ($space_position === false)
				$query_bits[] = $query;
			else {
				while ($space_position !== false) {
					$query_bits[] = UTF8::substr($query, 0, $space_position);
					$query = UTF8::trim(UTF8::substr($query, $space_position));
					$space_position = UTF8::strpos($query, ' ');
				}

				if (UTF8::strlen($query) > 0)
					$query_bits[] = $query;
			}
		}

		$notices = ORM::factory('notice');

		$notices->and_where_open();

		foreach($query_bits as $bit)
			$notices
				->or_where('title', 'LIKE', '%'.$bit.'%')
				->or_where('content', 'LIKE', '%'.$bit.'%');

		$notices->and_where_close();

		if (!$this->user_roles['admin'])
			$notices->where('display', '=', 1);

		$notices->reset(false);

		$pagination = Pagination::factory(array(
				'total_items' => $notices->count_all(),
				'items_per_page' => $this->notices_per_page,
			))
			->route_params(array(
				'action' => 'trazi',
				'controller' => 'obavijesti',
			));

		$notices = $notices->order_by('created', 'DESC')
			->offset($pagination->offset)
			->limit($pagination->items_per_page)
			->find_all();

		$this->search_query = $query_src;

		$this->content = View::factory('notices/container')
			->set('title', 'Rezultati pretrage <em>'.$query_src.'</em>')
			->set('content', View::factory('notices', array(
				'notices' => $notices,
				'user_roles' => $this->user_roles
			)))
			->set('pagination', $pagination->render());
	}

}
