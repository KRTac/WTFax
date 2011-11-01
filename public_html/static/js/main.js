function add_ajax_to_uri (uri) {
	var uri = uri.split('?');
	if (uri.length == 1) {
		return uri[0]+"?ajax";
	} else {
		var params = uri[1].split("&");
		var segment = false;
		for (var i in params) {
			segment = params[i].split("=");
			if (segment[0] == "ajax") {
				return uri[0]+"?"+uri[1];
			}
		}
		return uri[0]+"?"+uri[1]+"&ajax";
	}
}


$(document).ready(function () {
	var $content = $('#content'),
		$login_form = $('#login_form'),
		$flash_message = $content.find('.flash_message'),
		$category_list = $content.find('ul.category_selector'),
		$remove_notices = $content.find('.remove_notice');

	$login_form.submit(function () {
		var $email = $('#login_email'),
			$password = $('#login_password'),
			$remember = $('#login_remember'),
			$login_msg = $('#login_msg'),
			$form = $(this);

		$login_msg.html('<p>Prijava u tijeku...</p>');

		$.ajax({
			type: "POST",
			cache: false,
			dataType: "json",
			timeout: 10000,
			url: $form.attr('action'),
			data: {
				'email': $email.val(),
				'password': $password.val(),
				'remember': $remember.val(),
				'ajax': true,
			},
			success: function (response) {
				if (response['status']) {
					$login_msg.html('<p class="success">Prijavljeni ste. Osvježavam stranicu...</p>');
					window.location.reload(true);
				} else {
					$login_msg.html('<p class="error">'+response['error']+'</p>');
				}
			},
			error: function (msg) {
				$login_msg.html('<p class="error">Došlo je do problema kod spajanja na server.</p>');
			}
		});

		return false;
	});

	if ($flash_message.length) {
		setTimeout(function () {
			$flash_message.slideUp('slow', function () {
				$(this).remove();
			});
		}, 3000);
	}


	if ($category_list.hasClass('autoexpand_selected')) {
		$category_list.find('ul').each(function () {
			var $current_list = $(this);

			if ($current_list.find('input[name="_categories[]"]:checked').length > 0) {
				$current_list
					.css('display', 'block')
					.siblings('a.toggle_child_list')
					.addClass('minus');
			} else {
				$current_list.css('display', 'none');
			}
		});
	} else {
		$category_list
			.find('ul')
			.css('display', 'none');
	}

	$category_list
		.find('a.toggle_child_list')
		.click(function () {
			var $clicked = $(this),
				$affected_list = $clicked.siblings('ul');

			if ($affected_list.is(':visible')) {
				$clicked.removeClass('minus');
				$affected_list.slideUp(200);
			} else {
				$clicked.addClass('minus');
				$affected_list.slideDown(200);
			}

			return false;
		});

	$remove_notices.click(function () {
		var $clicked = $(this);

		if (confirm('Sigurno želite ukloniti zadanu obavijest?')) {
			location.href = $clicked.attr('href') + '?sigurno';
		}

		return false;
	});

});
