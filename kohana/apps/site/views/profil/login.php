<?php

echo '
		<div class="padded">
			<h2 class="big_text">Prijava</h2>
			<hr />
			<form method="post" action="/prijava">
				<table cellspacing="0" class="form">';

if ($error) {
	echo '
					<tr>
						<td colspan="2">
							<p class="error">'.$error.'</p>
						</td>
					</tr>';
}

echo '
					<tr>
						<td class="left"><label for="input_email">Email:</label></td>
						<td class="right">
							<input type="text" name="email" id="input_email" value="'.HTML::chars($email).'" />
						</td>
					</tr>
					<tr>
						<td class="left"><label for="input_password">Lozinka:</label></td>
						<td class="right">
							<input type="password" name="password" id="input_password" value="" />
						</td>
					</tr>
					<tr>
						<td class="left"></td>
						<td class="right">
							<input type="checkbox" name="remember" id="login_remember" value="1"'.($remember ? ' checked="checked"' : '').' />
							<label for="login_remember">Zapamti me</label>
						</td>
					</tr>
					<tr>
						<td class="left"><input type="hidden" name="referer" value="'.$referer.'" /></td>
						<td class="right"><input type="submit" name="submit" value="Prijavi me" /></td>
					</tr>
				</table>
			</form>
		</div>';
