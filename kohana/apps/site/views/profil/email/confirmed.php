<?php

echo '
		<div class="padded">
			<h2 class="big_text">Potvrda email adrese</h2>
			<hr />';

if ($logged_in) {
	echo '
			<p>Uspješno ste potvrdili email adresu <strong>'.$user->email.'</strong>.</p>';
} else {
	echo '
			<p>Email adresa je potvrđena.</p>';
}

if ($user->email_notice) {
	echo '
		<p>Sve nove obavijesti kategorija koje ste odabrali ćete od sada dobivati na email.</p>
		<p>U <a href="/postavke">postavkama</a> možete isključiti slanje novih obavijesti na email.</p>';
} else {
	echo '
		<p>U <a href="/postavke">postavkama</a> možete uključiti opciju primanja svih novih Vama namijenjenih obavijesti na email.</p>';
}

echo '
		</div>';
