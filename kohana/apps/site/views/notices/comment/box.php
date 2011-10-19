 <?php

$config = Kohana::$config->load('common');

echo '
					<div id="komentar'.$comment->id.'" class="comment_box'.($user && $user->id == $comment->user->id ? ' own' : '').'">
						<p class="info">'.date($config['date_format'], $comment->created).($comment->user->loaded() ? ' by '.$comment->user->name : '').'</p>
						<div>'.$comment->content.'</div>
					</div>';
