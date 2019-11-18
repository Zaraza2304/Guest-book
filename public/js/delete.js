$(document).ready(function () {
	$(document).on('click', '.comment-delete',function (event) {
		let id_comment = event.target.id;
		console.log(id_comment);

		$.ajax({
			type: 'POST',
			url: '/index.php/ajax/delete',
			data: ({
				'id_comment' : id_comment,
			}),
			success: function (response) {
				if (response) {
					//console.log('Ответ получен');
					//console.log('response '+ response);
					$('#bl'+id_comment).remove();
				} else {
					console.log('Error');
				}
			},
		});
	});
});
