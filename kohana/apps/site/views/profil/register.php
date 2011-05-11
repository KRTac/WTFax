<?php

echo '
		<div class="padded">
			<h2 class="big_text">Registracija</h2>
			<hr />
			<form method="post" action="/registracija">
				<table cellspacing="0" class="form">';

if ($input_errors) {
	if (!empty($input_errors['_external'])) {
		$input_errors = array_merge($input_errors, $input_errors['_external']);
		unset($input_errors['_external']);
	}

	echo '
					<tr>
						<td colspan="2">';

	foreach ($input_errors as $e) {
		echo '
							<p class="error">'.$e.'</p>';
	}

	echo '
						</td>
					</tr>';
}

echo '
					<tr>
						<td class="left"><span class="required">*</span><label for="inputName">Puno ime:</label></td>
						<td class="right">
							<input type="text" name="name" id="inputName" value="'.$user->name.'" />
							<p>Unesite svoje puno ime kako bi mogli primati obavijesti koje se tiču samo Vas (npr. "Morate se javiti u referadu" ili slično).</p>
						</td>
					</tr>
					<tr>
						<td class="left"><span class="required">*</span><label for="inputEmail">Email:</label></td>
						<td class="right">
							<input type="text" name="email" id="inputEmail" value="'.HTML::chars($user->email).'" />
							<p>Možete odabrati opciju da Vaše obavijesti dobivate na email. Email je također potreban kod prijave u sustav i resetiranja lozinke. Poslat ćemo Vam email pomoću kojeg možete potvrditi zadanu email adresu.</p>
							<p><input type="checkbox" name="email_notice" id="inputEmailNotice" value="1"'.($user->email_notice ? ' checked="checked"' : '').' /><label for="inputEmailNotice"><strong>Šalji mi nove obavijesti na email (email mora biti potvrđen)</strong></label></p>
						</td>
					</tr>
					<tr>
						<td class="left"><span class="required">*</span><label for="inputPassword">Lozinka:</label></td>
						<td class="right">
							<input type="password" name="password" id="inputPassword" value="" />
							<p>Najmanje 5 znakova.</p>
						</td>
					</tr>
					<tr>
						<td class="left"><span class="required">*</span><label for="inputPasswordConfirm">Potvrda lozinke:</label></td>
						<td class="right">
							<input type="password" name="password_confirm" id="inputPasswordConfirm" value="" />
							<p>Ponovite lozinku.</p>
						</td>
					</tr>
					<tr>
						<td class="left"><span class="required">*</span>Kategorije:</td>
						<td class="right">
							<p>Odaberite kategorije obavijesti koje želite primati. Preporuča se da primate najmanje obavijesti cijelog veleučilišta, obavijesti svog studija i obavijesti godine studija u koju ste upisani.</p>
							<p><strong>Napomena:</strong> Odabir jedne kategorije ne podrazumijeva njezine podkategorije.</p><br />
							'.Model_Category::render_tree(null, true, 'category_selector', null, $selected_categories).'
						</td>
					</tr>
					<tr>
						<td class="left"></td>
						<td class="right"><input type="submit" name="submit" value="Registriraj me" /></td>
					</tr>
				</table>
			</form>
		</div>';
