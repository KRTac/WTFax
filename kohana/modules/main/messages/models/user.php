<?php defined('SYSPATH') or die('No direct script access.');

return array(
	'email' => array(
		'not_empty' => 'Morate zadati email adresu',
		'min_length' => 'Email mora sadržavati najmanje :param2 znaka',
		'max_length' => 'Email može sadržavati najviše :param2 znakova',
		'email' => 'Morate zadati valjanu email adresu',
		'email_available' => 'Zadana email adresa je već registrirana. <a href="/lozinka">Zaboravili ste lozinku?</a>',
	),
	'name' => array(
		'not_empty' => 'Morate zadati ime',
		'min_length' => 'Ime mora sadržavati najmanje :param2 znaka',
		'max_length' => 'Ime može sadržavati najviše :param2 znakova',
	),
	'notices_per_page' => array(
		'not_empty' => 'Morate zadati broj obavijesti po stranici',
		'range' => 'Broj obavijesti po stranici mora biti između :param2 i :param3 znakova',
	),
);
