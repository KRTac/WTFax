<?php

$config = Kohana::$config->load('common');

echo '
				<div class="entry'.(isset($standalone) && $standalone ? ' standalone' : '').'">';

if ($notice->title) {
	echo '
					<h1 class="title"><a href="/obavijest/'.$notice->id.'/'.$notice->url_text.'">'.$notice->title.'</a></h1>';
}

$comments = $notice->comments
	->where('display', '=', 1)
	->reset(false);

$comment_count = $comments->count_all();

echo '
					<div class="info"><span><a href="/obavijest/'.$notice->id.'/'.$notice->url_text.'#komentari">'.Comment::humanize_count($comment_count).'</a></span><span class="delimiter">|</span><span>' . ($notice->user->loaded() ? $notice->user->name.', ' : '') . date($config['date_format'], $notice->created);

echo '</span><span class="delimiter">|</span><span>kategorije: ';

$notice_categories = $notice->categories
	->where('display', '=', 1)
	->find_all();
$categories_html = false;

foreach ($notice_categories as $cat) {
	$categories_html .= '<a href="/kategorija/'.$cat->id.'/'.$cat->url_text.'">'.$cat->name.'</a>, ';
}

echo UTF8::substr($categories_html, 0, -2).'</span></div>';

if ($user_roles['admin'] && (!isset($standalone) || !$standalone) && $notice->display != 1) {
	echo '
					<p class="admins"><span>Ova obavijest nije odobrena. <a class="show_hide_notice" href="/admin/obavijesti/odobri/' . $notice->id . '">Odobri obavijest</a></span></p>';
}

echo '
					<div class="content">'.$notice->content.'</div>
				</div>';

if (isset($standalone) && $standalone) {
	if ($user_roles['admin']) {
		echo '
				<div class="inline_notice_admin">
					<h2 class="big_text">Administracija obavijesti</h2>
					<hr />';

		if ($notice->display)
			echo '
					<a class="button lock icon" href="/admin/obavijesti/sakrij/' . $notice->id . '">Sakrij obavijest</a>';
		else
			echo '
					<a class="button unlock icon" href="/admin/obavijesti/odobri/' . $notice->id . '">Prikaži obavijest</a>';

		echo '
					<a class="button danger trash icon" href="/admin/obavijesti/brisi/' . $notice->id  . '" onclick="return confirm(\'Jeste li sigurni da želite izbrisati ovu obavijest?\');">Trajno izbriši</a>
				</div>';
	}

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
							<button class="button primary comment icon" id="comment_submit" name="submit" type="submit" value="Komentiraj">Komentiraj</button>
						</div>
					</form>';
	}
	echo '
				</div>';
}
