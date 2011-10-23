<?php

$config = Kohana::$config->load('common');

echo '
				<div class="entry'.(isset($standalone) && $standalone ? ' standalone' : '').'">';

if ($notice->title) {
	echo '
					<h1 class="title"><a href="/obavijest/'.$notice->id.'/'.$notice->url_text.'/">'.$notice->title.'</a></h1>';
}

$comments = $notice->comments
	->where('display', '=', 1)
	->reset(false);

$comment_count = $comments->count_all();

echo '
					<div class="info"><span><a href="/obavijest/'.$notice->id.'/'.$notice->url_text.'/#komentari">'.Comment::humanize_count($comment_count).'</a></span><span class="delimiter">|</span><span>'.date($config['date_format'], $notice->created);

if ($notice->user->loaded()) {
	echo ' by '.$notice->user->name;
}

echo '</span><span class="delimiter">|</span><span>kategorije: ';

$notice_categories = $notice->categories
	->where('display', '=', 1)
	->find_all();
$categories_html = false;

foreach ($notice_categories as $cat) {
	$categories_html .= '<a href="/kategorija/'.$cat->id.'">'.$cat->name.'</a>, ';
}

echo UTF8::substr($categories_html, 0, -2).'</span></div>
					<div class="content">'.$notice->content.'</div>
				</div>';

if (isset($standalone) && $standalone) {
	echo '
				<div id="komentari">
					<h2 class="big_text">Komentari</h2>
					<hr />
					<div id="comment_container">';

	if ($comment_count) {
		$comments = $comments
			->order_by('created', 'ASC')
			->find_all();

		foreach ($comments as $comment) {
			echo View::factory('notices/comment/box', array(
				'comment' => $comment,
				'user' => $user
			));
		}
	}

	echo '
					</div>';

	if ($user) {
		echo '
					<form id="add_comment_form" method="post" action="/komentiraj/'.$notice->id.'">
						<div id="comment_submit_messages"></div>
						<textarea id="comment_content" rows="5" cols="80" class="tinymce" name="content"></textarea>
						<div class="actions">
							<button class="add primary" id="comment_submit" name="submit" type="submit" value="Komentiraj"><span class="comment icon"></span>Komentiraj</button>
						</div>
					</form>';
	}
	echo '
				</div>';
}
