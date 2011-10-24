<?php

echo '
<p class="pagination">';

if ($first_page !== FALSE) {
	echo '
		<a href="'.HTML::chars($page->url($first_page)).'" rel="first">prva</a>';
} else {
	echo '
		<span>prva</span>';
}

if ($previous_page !== FALSE) {
	echo '
		<a href="'.HTML::chars($page->url($previous_page)).'" rel="prev">«</a>';
} else {
	echo '
		<span>«</span>';
}

if ($total_pages > 9) {
	$i = $current_page - 4;
	$to = $current_page + 4;
	$last_pages = 0;

	if ($i < 1) {
		$to += abs($i) + 1;
		$i = 1;
	} else {
		if ($to > $total_pages) {
			$i -= $to - $total_pages;
			$to = $total_pages;
		}
	}

	if ($total_pages - $to > 2) {
		$last_pages = 1;
	}

	for (; $i <= $to; $i++) {
		if ($i == $current_page) {
			echo '
		<span>'.$i.'</span>';
		} else {
			echo '
		<a href="'.HTML::chars($page->url($i)).'">'.$i.'</a>';
		}
	}

	if ($last_pages) {
		echo '
		<span class="separator">…</span>';

		for ($i = $total_pages - $last_pages; $i <= $total_pages; $i++) {
			echo '
		<a href="'.HTML::chars($page->url($i)).'">'.$i.'</a>';
		}
	}

} else {
	for ($i = 1; $i <= $total_pages; $i++) {
		if ($i == $current_page) {
			echo '
		<span>'.$i.'</span>';
		} else {
			echo '
		<a href="'.HTML::chars($page->url($i)).'">'.$i.'</a>';
		}
	}
}

if ($next_page !== FALSE) {
	echo '
		<a href="'.HTML::chars($page->url($next_page)).'" rel="next">»</a>';
} else {
	echo '
		<span>»</span>';
}

if ($last_page !== FALSE) {
	echo '
		<a href="'.HTML::chars($page->url($last_page)).'" rel="last">zadnja</a>';
} else {
	echo '
		<span>zadnja</span>';
}

echo '
</p>';
