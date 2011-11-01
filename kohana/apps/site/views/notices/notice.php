<?php

echo '
		<div class="padded">'.
	View::factory('notices/box', array(
		'notice' => $notice,
		'standalone' => true,
		'user' => $user,
		'user_roles' => $user_roles
	)).'
		</div>';
