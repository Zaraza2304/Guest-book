$(document).ready(function () {
	$(document).on('click', '.img_edit',function () {

		let id_comment = $(this).attr('data_rec');
		console.log('id: ' + id_comment);
		let parent = $(this)[0].parentElement.parentElement;

		$.ajax({
			type: 'POST',
			url: 'main.php',
			data: ({
				'edit' : true,
				'id_comment' : id_comment,
			}),
			success: function (response) {
				if (response == '1') {
					console.log('Ответ получен ' + response);
					parent.remove();

				} else {
					console.log('Error ' + response);
				}
			},
		});
	});
});
