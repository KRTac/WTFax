<?php

echo '
		<div class="padded">
			<h2 class="big_text">Zaboravili ste lozinku?</h2>
			<hr />
			<p>Upišite email adresu kojom se prijavljujete u Vaš korisnički račun kako bi Vam mogli poslati email s informacijama potrebnim za resetiranje lozinke.</p>
			<form method="post" action="/lozinka">
				<table cellspacing="0" class="form spaced">';

if ($input_errors) {
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
						<td class="left"><label for="input_email">Vaša email adresa:</label></td>
						<td class="right">
							<input type="text" name="email" id="input_email" value="'.$the_email.'" />
						</td>
					</tr>
					<tr>
						<td class="left"></td>
						<td class="right"><input type="submit" name="submit" value="Pošalji mi email" /></td>
					</tr>
				</table>
			</form>
		</div>';
