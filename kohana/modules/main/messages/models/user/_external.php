<?php defined('SYSPATH') or die('No direct script access.');

return array(
	'password' => array(
		'not_empty' => 'Morate zadati lozinku',
		'min_length' => 'Lozinka mora sadržavati najmanje :param2 znakova',
	),
	'password_confirm' => array(
		'matches' => 'Lozinke se ne podudaraju',
	),
	'categories_selected' => array(
		'equals' => 'Morate odabrati najmanje jednu kategoriju',
	),
);
