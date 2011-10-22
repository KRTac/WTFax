<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Profil extends Controller_Base {

	public function action_registracija () {
		if ($this->user) {
			$this->request->redirect('/');
		}
		$this->titles[] = 'Registracija';

		$user = new Model_User();
		$user->email_notice = 1;
		$input_errors = array();
		$selected_cats = array();

		if ($_POST) {
			$valid_categories = array();
			if (!empty($_POST['_categories']) && is_array($_POST['_categories'])) {
				foreach ($_POST['_categories'] as $id) {
					$cat = ORM::factory('category', array(
						'id' => (int) $id,
						'display' => 1
					));

					if (!$cat->loaded()) {
						continue;
					}

					$selected_cats[] = $id;
					$valid_categories[] = $cat;
				}
			}

			try {
				$values = array_merge($_POST, array('categories_selected' => ($selected_cats ? 1 : 0)));

				$extra_validation = Model_User::get_password_validation($values)
					->rule('password', 'not_empty')
					->rule('categories_selected', 'equals', array(':value', 1));

				$user->values($values, array(
					'name',
					'email',
					'password',
				));

				$user->check($extra_validation);

				$user->email_notice = isset($_POST['email_notice']) ? 1 : 0;
				$user->email_confirm = Random::hash();
				User::send_email_confirmation($user);

				$user->create();

				foreach ($valid_categories as $cat) {
					$user->add('categories', $cat);
				}

				$user->add('roles', ORM::factory('role', array('name' => 'login')));

				$this->request->redirect('/registracija/great_success'.($user->email_notice ? '?email' : ''));
			} catch (ORM_Validation_Exception $e) {
				$input_errors = $e->errors('models');
			}
		}

		$this->content = View::factory('profil/register')
			->set('input_errors', $input_errors)
			->set('selected_categories', $selected_cats)
			->bind('user', $user);
	}

	public function action_prijava () {
		if (isset($_SERVER['HTTP_REFERER'])) {
			$referer = UTF8::substr($_SERVER['HTTP_REFERER'], UTF8::strpos($_SERVER['HTTP_REFERER'], '/', 8));
			if (UTF8::substr($referer, 0, 8) == '/prijava') {
				$referer = '/';
			}
		} else {
			$referer = '/';
		}

		if ($this->user) {
			$this->request->redirect($referer);
		}

		$email = $remember = false;
		$response = array(
			'status' => false,
			'error' => false
		);

		$ajax = isset($_POST['ajax']) ? true : false;

		if ($_POST) {
			$referer = isset($_POST['referer']) ? $_POST['referer'] : $referer;

			if (empty($_POST['email']) || empty($_POST['password'])) {
				$response['error'] = 'Morate upisati korisničko ime i lozinku';
			} else {
				$email = $_POST['email'];
				$remember = (isset($_POST['remember']) && $_POST['remember'] == '1')
					? true
					: false;

				if (Valid::email($email) && Auth::instance()->login($email, $_POST['password'], $remember)) {
					if ($ajax) {
						$response['status'] = true;
					} else {
						$this->request->redirect($referer);
					}
				} else {
					$response['error'] = 'Korisničko ime i/ili lozinka nisu važeči';
				}
			}

			if ($ajax) {
				$this->auto_render = false;
				echo json_encode($response);
			}
		}

		$this->titles[] = 'Prijava';
		$this->show_sidebar = false;

		$this->content = View::factory('profil/login')
			->set('email', $email)
			->set('remember', $remember)
			->set('error', $response['error'])
			->set('referer', $referer);
	}

	public function action_odjava () {
		Session::instance()->set('knows_password', false);

		Auth::instance()->logout();
		$this->request->redirect('/');
	}

	public function action_potvrda_identiteta () {
		if (!$this->user) {
			$this->request->redirect('/');
		}

		$session = Session::instance();

		$knows_password = $session->get('knows_password', false);
		$redirect = $session->get('identity_confirmation_redirect', false);

		$redirect = $redirect ? $redirect : '/';

		if ($knows_password) {
			$this->request->redirect($redirect);
		}

		$input_errors = array();

		if ($_POST) {
			if (isset($_POST['password']) && Auth::instance()->check_password($_POST['password'])) {
				$session->set('knows_password', true);
				$session->delete('identity_confirmation_redirect');
				$this->request->redirect($redirect);
			} else {
				$session->set('knows_password', false);

				if (empty($_POST['password'])) {
					$input_errors[] = 'Morate zadati lozinku';
				} else {
					$input_errors[] = 'Lozinka ne odgovara';
				}
			}
		}

		$this->titles[] = 'Potvrda identiteta';
		$this->titles[] = $this->user->name;

		$this->content = View::factory('profil/confirm_identity')
			->set('input_errors', $input_errors)
			->bind('user', $this->user);
	}

	public function action_postavke () {
		if (!$this->user) {
			$this->content = View::factory('profil/must_login');

			return;
		}

		if (!Session::instance()->get('knows_password', false) && (time() - $this->user->last_login) > 30) {
			Session::instance()->set('identity_confirmation_redirect', '/postavke');
			$this->request->redirect('/potvrda_identiteta');
		} else {
			Session::instance()->set('knows_password', true);
		}

		$this->titles[] = 'Postavke';
		$this->titles[] = $this->user->name;

		$input_errors = array(
			'categories' => array(),
			'general' => array(),
			'password' => array(),
		);
		$selected_cats = $this->user->categories->find_all()->as_array('id');

		if (isset($_POST['categories'])) {
			$selected_cats = array();
			if (!empty($_POST['_categories']) && is_array($_POST['_categories'])) {
				foreach ($_POST['_categories'] as $id) {
					$cat = ORM::factory('category', array(
						'id' => (int) $id,
						'display' => 1
					));

					if (!$cat->loaded()) {
						continue;
					}

					$selected_cats[] = $cat;
				}
			}

			if (!$selected_cats) {
				$input_errors['categories'][] = 'Morate odabrati bar jednu kategoriju';
			} else {
				DB::delete('categories_users')
					->where('user_id', '=', $this->user->id)
					->execute();

				foreach ($selected_cats as $cat) {
					$this->user->add('categories', $cat);
				}
				Session::instance()->set('msg_user_category_settings_saved', true);

				$this->request->redirect('/postavke#kategorije');
			}
		} else if (isset($_POST['general'])) {
			$old_email = $this->user->email;
			$this->user->values($_POST, array('email', 'name', 'notices_per_page'));

			$this->user->email_notice = (isset($_POST['email_notice']) && $_POST['email_notice'] == '1') ? 1 : 0;

			if ($old_email != $this->user->email) {
				$this->user->email_confirm = Random::hash();
				User::send_email_confirmation($this->user);
			}

			try {
				$this->user->update();
				Session::instance()->set('msg_user_general_settings_saved', true);

				$this->request->redirect('/postavke#opce_postavke');
			} catch (ORM_Validation_Exception $e) {
				$input_errors['general'] = $e->errors('models');
			}
		} else if (isset($_POST['password_submit'])) {
			try {
				$this->user->update_user($_POST, array('password'));
				Session::instance()->set('msg_user_password_changed', true);

				$this->request->redirect('/postavke#lozinka');
			} catch (ORM_Validation_Exception $e) {
				$input_errors['password'] = $e->errors('models');
			}
		}

		$this->content = View::factory('profil/settings')
			->set('input_errors', $input_errors)
			->set('selected_categories', $selected_cats)
			->bind('user', $this->user);
	}

	public function action_potvrda_emaila () {
		if (isset($_GET['resend'])) {
			if (!$this->user) {
				$this->request->redirect('/');
			}
			$this->titles[] = 'Email za potvrdu adrese';
			$this->user->email_confirm = Random::hash();
			User::send_email_confirmation($this->user);
			$this->user->update();

			$this->content = View::factory('profil/email/resend_confirmation')
				->set('user', $this->user);

			return;
		}

		$id = $this->request->param('id', false);
		$hash = $this->request->param('hash', false);

		if (!$id || !$hash) {
			$this->request->redirect('/');
		}

		$user = ORM::factory('user')
			->where('id', '=', $id)
			->where('email_confirm', '=', $hash)
			->limit(1)
			->find();

		if (!$user->loaded()) {
			$this->request->redirect('/');
		}
		$this->titles[] = 'Email uspješno potvrđen';

		$user->email_confirm = null;
		$user->save();

		$this->content = View::factory('profil/email/confirmed', array(
			'logged_in' => ($this->user && $this->user->id == $user->id ? true : false),
			'user' => $user
		));
	}

	public function action_great_success () {
		if ($this->user) {
			$this->request->redirect('/');
		}

		$this->content = View::factory('profil/registration/success');
	}

}
