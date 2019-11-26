<?php session_start();
include "../main.php";
?>
<?php
			 $data = $comments_controller->get_data_user();
			 $global_params['edit_data'] = $data[0];
			 unset($data);
		?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $global_params['page']['title']; ?></title>
	<link type="text/css" rel="stylesheet" href="../../public/css/reset.css">
	<link type="text/css" rel="stylesheet" href="../../public/css/main.css">
</head>
<body>
	<?php /*echo '<pre>';
        var_dump($global_params);
        echo '</pre>';*/
    ?>
	<div class="container">
		 <div class="col-lg">
            <h1>Редактирование коментария</h1>
            <?php //echo $comments_status;?>
        </div>

		<div class="home_link">
			<a class="link" href="/">Главная</a>
		</div>
		<?php

		$message = '<div class="col-lg">
						<h2>Данные успешно обновлены</h2>
					</div>';
		if($_POST['result_edit']) {
			echo $message;
		}
		?>


		<div class="col-lg">
			<form action="" method="POST">
			<div class="field_block_left">

					<input type="hidden" name="hidden" value="<?php  echo $global_params['page']['page_id']; ?>">
					<input type="hidden" name="id" value="<?php  echo $global_params['edit_data']['id']; ?>">

                    <label for="comment_name" class="l_name" id="comment_name">Имя</label>
                    <input type="text" class="i_name" id="f_name"
                    name="comment_name" value="<?php echo $global_params['edit_data']['user_name']; ?>" readonly>
                </div>
                <div class="field_block_right">
                    <label for="comment_e_mail" class="l_name" id="comment_e_mail">E-mail</label>
                    <input type="email" class="i_name" id="f_email"
                    name="comment_e_mail" value="<?php echo $global_params['edit_data']['e_mail']; ?>" readonly>
                </div>
                <div class="field_block">
                    <label for="comment_home_url" class="l_name" id="comment_home_url">Адресс домашней страницы</label>
                    <input type="text" class="i_name" id="f_home_url"
                    name="comment_home_url" value="<?php echo $global_params['edit_data']['home_page']; ?>">
                </div>
                <div class="comm_block">
                    <label for="comment" class="l_comment" id="comment">Коментарий</label>
                    <textarea name="comment" class="textarea"><?php echo $global_params['edit_data']['comment']; ?></textarea>
                </div>
                <div class="comm_block">
                    <input class="submit" id="submit" type="submit" name="save" value="Сохранить">
                </div>
		</form>
		</div>

	</div>
</body>
</html>