<?php

$session = Session::instance();

echo '
		<div class="padded">
			<h2 class="big_text" id="kategorije">Kategorije</h2>
			<hr />';

if ($session->get('msg_user_category_settings_saved', false)) {
	$session->delete('msg_user_category_settings_saved');

	echo '
			<div class="flash_message positive"><p>Odabrane kategorije su spremljene.</p></div>';
}

echo '
			<p>Odaberite kategorije obavijesti koje želite primati. Preporuča se da primate najmanje obavijesti cijelog veleučilišta, obavijesti svog studija i obavijesti godine studija u koju ste upisani.</p>
			<p><strong>Napomena:</strong> Odabir jedne kategorije ne podrazumijeva njezine podkategorije.</p>
			<form method="post" action="/postavke">';

foreach ($input_errors['categories'] as $e) {
	echo '
				<p class="error">'.$e.'</p>';
}

echo Model_Category::render_tree(null, true, 'category_selector autoexpand_selected spaced', null, $selected_categories).'
				<div>
					<button class="button approve icon" type="submit" name="categories" value="Spremi kategorije">Spremi kategorije</button>
				</div>
			</form>
			<br />
			<h2 class="big_text" id="opce_postavke">Opće postavke</h2>
			<hr />';

if ($session->get('msg_user_general_settings_saved', false)) {
	$session->delete('msg_user_general_settings_saved');

	echo '
			<div class="flash_message positive"><p>Opće postavke su uspješno spremljene.</p></div>';
}

echo '
			<form method="post" action="/postavke">
				<table cellspacing="0" class="form">';

if ($input_errors['general']) {
	echo '
					<tr>
						<td colspan="2">';

	foreach ($input_errors['general'] as $e) {
		echo '
							<p class="error">'.$e.'</p>';
	}

	echo '
						</td>
					</tr>';
}

echo '
					<tr>
						<td class="left"><label for="input_email">Email:</label></td>
						<td class="right">
							<input type="text" name="email" id="input_email" value="'.$user->email.'" />
							<p>Možete odabrati opciju da Vaše obavijesti dobivate na zadanu email adresu. Ukoliko izmjenite email adresu, ponovno ćemo Vam poslati email pomoću kojeg ćete moći potvrditi novu email adresu.</p>'.
	(empty($user->email_confirm)
		? ''
		: '
							<p class="error">Napomena: Morate potvrditi zadanu email adresu. Možete zatražiti <a href="/potvrda_emaila?resend">ponovno slanje emaila za potvrdu adrese</a>.</p>').'
							<p><input type="checkbox" name="email_notice" id="input_email_notice" value="1"'.($user->email_notice ? ' checked="checked"' : '').' /><label for="input_email_notice"><strong>Šalji nove obavijesti na email (email mora biti potvrđen)</strong></label></p>
						</td>
					</tr>
					<tr>
						<td class="left"><label for="input_name">Puno ime:</label></td>
						<td class="right">
							<input type="text" name="name" id="input_name" value="'.$user->name.'" />
						</td>
					</tr>
					<tr>
						<td class="left"><label for="input_notices_per_page">Broj obavijesti po stranici:</label></td>
						<td class="right">
							'.Form::select('notices_per_page', array(10 => '10', 15 => '15', 20 => '20', 25 => '25'), $user->notices_per_page, array('id' => 'input_notices_per_page')).'
						</td>
					</tr>
					<tr>
						<td class="left"></td>
						<td class="right"><button class="button user icon" type="submit" name="general" value="Spremi postavke">Spremi postavke</button></td>
					</tr>
				</table>
			</form>
			<br />
			<h2 class="big_text" id="lozinka">Lozinka</h2>
			<hr />';

if ($session->get('msg_user_password_saved', false)) {
	$session->delete('msg_user_password_saved');

	echo '
			<div class="flash_message positive"><p>Lozinka je uspješno promijenjena.</p></div>';
}

echo '
			<form method="post" action="/postavke">
				<table cellspacing="0" class="form">';

if ($input_errors['password']) {
	if (!empty($input_errors['password']['_external'])) {
		$input_errors['password'] = array_merge($input_errors['password'], $input_errors['password']['_external']);
		unset($input_errors['password']['_external']);
	}

	echo '
					<tr>
						<td colspan="2">';

	foreach ($input_errors['password'] as $e) {
		echo '
							<p class="error">'.$e.'</p>';
	}

	echo '
						</td>
					</tr>';
}

echo '
					<tr>
						<td class="left"><label for="input_password">Lozinka:</label></td>
						<td class="right">
							<input type="password" name="password" id="input_password" value="" />
							<p>Najmanje 5 znakova.</p>
						</td>
					</tr>
					<tr>
						<td class="left"><label for="input_password_confirm">Potvrda lozinke:</label></td>
						<td class="right">
							<input type="password" name="password_confirm" id="input_password_confirm" value="" />
							<p>Ponovite lozinku.</p>
						</td>
					</tr>
					<tr>
						<td class="left"></td>
						<td class="right"><button class="button key icon" type="submit" name="password_submit" value="Promijeni lozinku">Promijeni lozinku</button></td>
					</tr>
				</table>
			</form>
		</div>';
