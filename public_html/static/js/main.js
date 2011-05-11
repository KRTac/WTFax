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
		$flash_message = $content.find('.flash_message');

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

});
