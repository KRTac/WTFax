<?php

echo '
		<div class="padded">';

if (!empty($title)) {
	echo '
			<h2 class="big_text">'.$title.'</h2>
			<hr />';
}

echo $pagination.'
			<div id="notices_wrapper">'.$content.'
			</div>
		</div>';
