<?php

echo '
		<div id="side">';

if ($user) {
	echo '
			<div class="section">
				<h2><a href="/dodaj">Dodaj obavijest</a></h2>
			</div>
			<div class="section">
				<h3 class="title">'.$user->name.'</h3>
				<hr />
				<ul class="content">
					<li><a href="/postavke">Postavke</a></li>
					<li><a href="/odjava">Odjava</a></li>
				</ul>
			</div>';
} else {
	echo '
			<div class="section">
				<h3 class="title">Prijava</h3>
				<hr />
				<div class="content">
					<form action="/prijava" id="login_form" method="post">
						<table cellspacing="0" class="login">
								<tr>
									<td colspan="2" id="login_msg"></td>
								</tr>
								<tr>
									<td class="label"><label for="login_email">Email:</label></td>
									<td><input type="text" name="email" id="login_email" value="" tabindex="1" /></td>
								</tr>
								<tr>
									<td class="label"><label for="login_password">Lozinka:</label></td>
									<td><input type="password" name="password" id="login_password" value="" tabindex="2" /></td>
								</tr>
								<tr>
									<td class="padded" colspan="2">
										<input type="submit" name="submit" value="Prijavi me" tabindex="4" />
										<input type="checkbox" name="remember" id="login_remember" value="1" tabindex="3" /><label for="login_remember">Zapamti me</label>
									</td>
								</tr>
						</table>
					</form>
					<p><a href="/lozinka">Zaboravili ste lozinku?</a></p>
					<p><a href="/registracija">Registrirajte se</a> ukoliko ste student VELV-a.</p>
				</div>
			</div>';
}

echo '
		</div>';
