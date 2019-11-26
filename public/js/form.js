$(document).ready(function () {
	$('form').submit(function (event) {

		event.preventDefault();

		let p_id = $("#hidden_block").text();
		let comment_name = $("#f_name");
		let comment_email = $("#f_email");
		let comment_home_url = $("#f_home_url").val();
		let comment_text = $(".textarea");
		let button = $("#submit").val();


		if (comment_name.val().length < 3 ||
			comment_email.val().length < 4 ||
			comment_text.val().length < 2) {

			comment_name.css('borderColor', 'red');
			comment_email.css('borderColor', 'red');
			comment_text.css('borderColor', 'red');

		} else {

			let d = new Date();
			let h = d.getHours();
			let m = d.getMinutes();
			let s = d.getSeconds();

			h = (h < 10) ? ("0" + h) : h;
			m = (m < 10) ? ("0" + m) : m;
			s = (s < 10) ? ("0" + s) : s;

			let date = $.datepicker.formatDate('yy-mm-dd', new Date());
			let datetime = date + " " + h + ":" + m + ":" + s;

			/*console.log('Id страницы: '+ p_id);
			console.log('Имя: ' + comment_name.val());
			console.log('E-mail: ' + comment_email.val());
			console.log('Home-url: ' + comment_home_url);
			console.log('Comment: ' + comment_text.val());
			console.log('Button: ' + button);
			console.log('Отправка Ajax');*/

			$.ajax({
				type: 'POST',
				//url: '/controller/Comments.php',
				url: 'main.php',
				data: ({
					"id" : p_id,
					"comment_name" : comment_name.val(),
					"comment_email" : comment_email.val(),
					"comment_home_url" : comment_home_url,
					"comment_text" : comment_text.val(),
					'time' : datetime,
					"button" : button,
				}),
				success: function (response) {
					if (response == 1) {
						console.log('Answer: ' + response);

						let out = '<tr>' +
							'<th>'+comment_name.val()+'</th>' +
							'<th>'+comment_email.val()+'</th>' +
							'<th>'+comment_text.val()+'</th>' +
							'<th>'+comment_home_url+'</th>' +
							'<th>'+datetime+'</th>' +
							'<th>'+'</th>' +
							'<th>'+'</th>' +
							'</tr>';

						$("#table").append(out);
					} else {
						console.log('Error response');
						console.log(response);
					}
				},
			});
		}
	});
});
