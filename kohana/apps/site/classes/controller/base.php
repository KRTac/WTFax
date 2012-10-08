<?php defined('SYSPATH') or die('No direct script access.');

abstract class Controller_Base extends Controller_Template {

	public $template = 'base';
	public $conf = array();
	public $title = false;
	public $titles = array();
	public $content = false;
	public $search_query = '';

	public $user = false;
	public $user_roles = array(
		'login' => false,
		'admin' => false,
	);
	public $notices_per_page = 10;

	public $active_menu_item = false;
	public $show_sidebar = true;

	public $_loaded_scripts = array();

	public function before () {
		parent::before();

		$this->user = Auth::instance()->get_user(false);

		if ($this->user) {
			$this->notices_per_page = $this->user->notices_per_page;

			$this->user_roles['login'] = $this->user->has('roles', 1);
			$this->user_roles['admin'] = $this->user->has('roles', 2);
		}

		$this->conf['common'] = Kohana::$config->load('common');

		$this->template->scripts = array();
	}

	public function after () {
		if ($this->auto_render) {
			if (!$this->title) {
				$this->titles[] = $this->conf['common']['title']['default'];

				for ($i = 0, $c = count($this->titles); $i < $c; $i++) {
					if ($i != 0) {
						$this->title .= $this->conf['common']['title']['separator'];
					}
					$this->title .= $this->titles[$i];
				}
			}

			$this->add_script('!main');

			$sidebar = '';
			if ($this->show_sidebar) {
				$sidebar = View::factory('sidebar')
					->set('user', $this->user)
					->set('user_roles', $this->user_roles);
			}

			$this->template
				->set('title', $this->title)
				->set('active_menu_item', $this->active_menu_item)
				->set('sidebar', $sidebar)
				->set('search_query', $this->search_query)
				->set('content', $this->content)
				->set('user', $this->user);
		}

		parent::after();
	}

	public function add_script ($script) {
		if (is_string($script)) {
			if ($this->is_loaded_script($script)) {
				return true;
			}

			switch ($script) {
			case '!jquery':
				$this->template->scripts[] = array(
					'type' => 'file',
					'script' => '/static/js/jquery-1.6.4.min.js'
				);
				break;

			case '!main':
				$this->add_script('!jquery');
				$this->template->scripts[] = array(
					'type' => 'file',
					'script' => '/static/js/main.js'
				);
				break;

			case '!tinymce':
				$this->add_script('!jquery');
				$this->template->scripts[] = array(
					'type' => 'file',
					'script' => '/static/js/tiny_mce/jquery.tinymce.js'
				);
				$this->template->scripts[] = array(
					'type' => 'onload',
					'script' => "
			$('textarea.tinymce').tinymce({
				script_url : '/static/js/tiny_mce/tiny_mce.js',

				theme : 'advanced',
				skin : 'o2k7',
				skin_variant : 'silver',
				language : 'hr',

				theme_advanced_buttons1 : 'bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,forecolorpicker,|,bullist,numlist,|,sub,sup,|,link,unlink,|,undo,redo,|,code',
				theme_advanced_buttons2 : '',
				theme_advanced_buttons3 : '',

				theme_advanced_toolbar_location : 'top',
				theme_advanced_toolbar_align : 'left',
				theme_advanced_statusbar_location : 'bottom',
				theme_advanced_resizing : true,
				theme_advanced_resize_horizontal: false,
				width : 613,
				height : 300,
			});"
				);
				break;

			case '!tinymce_comment':
				$this->add_script('!jquery');
				$this->template->scripts[] = array(
					'type' => 'file',
					'script' => '/static/js/tiny_mce/jquery.tinymce.js'
				);
				$this->template->scripts[] = array(
					'type' => 'onload',
					'script' => "
			$('#comment_content').tinymce({
				script_url : '/static/js/tiny_mce/tiny_mce.js',

				theme : 'advanced',
				skin : 'o2k7',
				skin_variant : 'silver',
				language : 'hr',

				theme_advanced_buttons1 : 'bold,italic',
				theme_advanced_buttons2 : '',
				theme_advanced_buttons3 : '',

				theme_advanced_toolbar_location : 'top',
				theme_advanced_toolbar_align : 'left',
				theme_advanced_statusbar_location : 'bottom',
				theme_advanced_resizing : true,
				theme_advanced_resize_horizontal: false,
				width : '100%',
				height : 50,
			});

			$('#add_comment_form').submit(function () {
				var \$comment_submit = $('#comment_submit'),
					\$comment_submit_messages = $('#comment_submit_messages');

				\$comment_submit.html('Šaljem komentar...');
				$.ajax({
					cache: false,
					data: {
						content: tinyMCE.get('comment_content').getContent(),
					},
					dataType: 'json',
					type: 'POST',
					url: add_ajax_to_uri($(this).attr('action')),
					success: function(data, status) {
						if (data.status == 'error') {
							\$comment_submit_messages.html('<p class=\"negative\">'+data.msg+'</p>');
						} else {
							tinyMCE.get('comment_content').setContent('');
							$('#comment_container').append(data.html);
							\$comment_submit_messages.html('');
						}
					},
					error: function() {
						\$comment_submit_messages.html('<p class=\"negative\">Došlo je do problema prilikom slanja komentara. Komentar nije poslan.</p>');
					},
					complete: function() {
						\$comment_submit.html('Komentiraj');
						$('#no_comments_msg').slideUp(200);
					}
				});

				return false;
			});"
				);
				break;

			default:
				return false;
			}

			$this->_loaded_scripts[$script] = true;
		} else if (is_array($script)) {
			$this->template->scripts[] = $script;
		} else {
			$this->template->scripts[] = array(
				'type' => 'inline',
				'script' => $script
			);
		}

		return true;
	}

	public function is_loaded_script ($script) {
		if (isset($this->_loaded_scripts[$script]) && $this->_loaded_scripts[$script] == true) {
			return true;
		}
		return false;
	}

}
