<?php

echo '
		<div class="padded">
			<h2 class="big_text">Resetiranje lozinke</h2>
			<hr />
			<form method="post" action="/lozinka/reset/'.$user->id.'/'.$hash.'">
				<table cellspacing="0" class="form spaced">';

if ($input_errors) {
	if (isset($input_errors['_external'])) {
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
						<td class="left">Vaš email:</td>
						<td class="right">
							<p>'.$user->email.'</p>
						</td>
					</tr>
					<tr>
						<td class="left"><label for="input_password">Nova lozinka:</label></td>
						<td class="right">
							<input type="password" name="password" id="input_password" value="" />
							<p>Najmanje 5 znakova.</p>
						</td>
					</tr>
					<tr>
						<td class="left"><label for="input_password_confirm">Potvrda lozinke:</label></td>
						<td class="right">
							<input type="password" name="password_confirm" id="input_password_confirm" value="" />
							<p>Ponovno upišite lozinku.</p>
						</td>
					</tr>
					<tr>
						<td colspan="2"><input type="submit" name="submit" value="Postavi novu lozinku" /></td>
					</tr>
				</table>
			</form>
		</div>';
