<?php session_start();?>
<html>
<?php
	include('main.php');
?>
<head>
	<title><?php echo $param['page']['title']; ?></title>
	<link type="text/css" rel="stylesheet" href="../../../public/css/reset.css">
	<link type="text/css" rel="stylesheet" href="../../../public/css/main.css">
</head>
<body>
<div class="container">
	<header>
	<div class="wrap_h">
         <?php //var_dump($_SESSION); ?>
		<h1>Главная страница</h1>
	</div>
	</header>
	<div class="main">
	<div class="content">
        <div class="link_">

            <p>Приветствую <?php echo $param['current_user']; ?></p>
            <?php 
                if ($param['current_user'] == 'Аноним') {
                    ?>
                    <p>Вы можете <a href="signup.php">зарегистрировать</a> или <a href="login.php">авторизироватся</a></p>
                    <?php
                }
            ?>
        </div>
		<p ><?php echo $param['page']['content']; ?></p>

	</div>
        <div class="col-lg">
            <h2>Коментарии</h2>
            <?php //echo $comments_status;?>
            <div id="hidden_block"><?php  echo $param['page']['page_id']; ?></div>
        </div>
        <div class="col-lg">
            <table>
                <tbody id="table">
                    <tr>
                        <th class="head_table">Имя</th>
                        <th class="head_table">E-mail</th>
                        <th class="head_table">Комментарий</th>
                        <th class="head_table">Домашняя страница</th>
                        <th class="head_table">Дата добавления</th>
                    </tr>

            <?php
            foreach ($param['comments'] as $row) { ?>
                <tr>
                    <th><?php echo $row['user_name'];?></th>
                    <th><?php echo $row['e_mail']; ?></th>
                    <th><?php echo $row['text'];?></th>
                    <th><?php echo $row['homepage']; ?></th>
                    <th><?php echo $row['created_at']; ?></th>
                </tr>

            <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="col-lg">
            <div class="inscription">
                <p>Добавить коментарий</p>
            </div>
            <form action="" method="POST">
                <div class="field_block_left">
                    <label for="comment_name" class="l_name" id="comment_name">Имя</label>
                    <input type="text" class="i_name" id="f_name" name="comment_name" placeholder="Обязательно">
                </div>
                <div class="field_block_right">
                    <label for="comment_e_mail" class="l_name" id="comment_e_mail">E-mail</label>
                    <input type="email" class="i_name" id="f_email" name="comment_e_mail" placeholder="Обязательно">
                </div>
                <div class="field_block">
                    <label for="comment_home_url" class="l_name" id="comment_home_url">Адресс домашней страницы</label>
                    <input type="text" class="i_name" id="f_home_url" name="comment_home_url" placeholder="http://">
                </div>
                <div class="comm_block">
                    <label for="comment" class="l_comment" id="comment">Коментарий</label>
                    <textarea name="comment" class="textarea" placeholder="Не более 1400 символов"></textarea>
                </div>
                <div class="comm_block">
                    <input class="submit" id="submit" type="submit" name="sent" value="Отправить">
                </div>
            </form>
        </div>
	</div>
	<footer>
	    <div class="footer_bl">
		    <p>Орешкин Василий, 2019</p>
	    </div>
	</footer>
</div>
	<script src="public/js/jquery_3.4.1.min.js"></script>
	<script src="public/js/jquery-ui.js"></script>
	<script src="public/js/form.js"></script>
	<script src="public/js/delete.js"></script>
</body>
</html>
