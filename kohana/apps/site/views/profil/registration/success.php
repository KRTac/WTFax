<?php

echo '
		<div class="padded">
			<h2 class="big_text">Registracija</h2>
			<hr />
			<p>Registracija je uspješna. Sad se možete prijaviti u sustav.</p>';

if (isset($_GET['email'])) {
	echo '
			<p><strong>Napomena:</strong> Morate potvrditi email adresu kako bi mogli primati obavijesti na email. Poslali smo Vam email pomoću kojeg možete potvrditi zadanu adresu.</p>';
}

echo '
		</div>';
