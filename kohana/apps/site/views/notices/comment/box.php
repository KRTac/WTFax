 <?php

$config = Kohana::$config->load('common');

echo '
					<div id="komentar'.$comment->id.'" class="comment_box'.($user && $user->id == $comment->user->id ? ' own' : '').'">
						<p class="info">'.($comment->user->loaded() ? $comment->user->name.', ' : '').date($config['date_format'], $comment->created).
						($user_roles['admin'] ? ' <a class="delete_comment" href="/admin/komentari/brisi/'.$comment->id.'" onclick="return confirm(\'Sigurno želite izbrisati komentar\');">Briši</a>' : '').'</p>
						<div>'.$comment->content.'</div>
					</div>';
