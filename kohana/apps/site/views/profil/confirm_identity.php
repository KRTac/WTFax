<?php

echo '
		<div class="padded">
			<h2 class="big_text">Potvrda identiteta</h2>
			<hr />
			<p>Morate potvrditi svoj identitet kako bi mogli nastaviti.</p>
			<form method="post" action="/potvrda_identiteta">
				<table cellspacing="0" class="form">';

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
						<td class="left"><label for="input_password">Lozinka:</label></td>
						<td class="right">
							<input type="password" name="password" id="input_password" value="" />
						</td>
					</tr>
					<tr>
						<td class="left"></td>
						<td class="right"><input type="submit" name="submit" value="Skeniraj me" /></td>
					</tr>
				</table>
			</form>
		</div>';
