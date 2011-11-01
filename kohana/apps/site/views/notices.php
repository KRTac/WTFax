<?php

foreach ($notices as $notice) {
	echo View::factory('notices/box', array(
		'notice' => $notice,
		'user_roles' => $user_roles
	));
}
