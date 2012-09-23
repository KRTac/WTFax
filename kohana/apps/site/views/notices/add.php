<?php

echo '
		<div class="padded">
			<h2 class="big_text">Dodaj obavijest</h2>
			<hr />';

echo '
			<form method="post" action="/dodaj">
				<table cellspacing="0" class="form add_notice">';

if ($input_errors) {
	echo '
					<tr>
						<td colspan="2">';

	foreach ($input_errors as $e) {
		echo '
							<p class="error">'.$e.'</p>';
	}

	echo '
						</td>
					</tr>';
}

echo '
					<tr>
						<td colspan="2" class="label"><span class="required">*</span><label for="inputTitle">Naslov:</label></td>
					</tr>
					<tr>
						<td colspan="2">
							<input type="text" class="big" name="title" id="inputTitle" value="'.$notice->title.'" />
						</td>
					</tr>
					<tr>
						<td colspan="2" class="label"><span class="required">*</span><label for="inputContent">Sadržaj:</label></td>
					</tr>
					<tr>
						<td colspan="2">
							<textarea class="tinymce" name="content" cols="50" rows="15" id="inputContent">'.$notice->content.'</textarea>
						</td>
					</tr>
					<tr>
						<td class="left">Kategorije:</td>
						<td class="right">
							<p><strong>Napomena:</strong> Odabir jedne kategorije ne podrazumijeva njezine podkategorije.</p><br />
							'.Model_Category::render_tree(null, true, 'category_selector autoexpand_selected', null, $selected_categories).'
						</td>
					</tr>
					<tr>
						<td colspan="2"><button class="button primary icon add" type="submit" name="submit" value="Objavi">Objavi</button></td>
					</tr>
				</table>
			</form>';

echo '
		</div>';
