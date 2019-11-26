<?php session_start();?>
<html>
<?php
	include('main.php');
?>
<head>
	<title><?php echo $global_params['page']['title']; ?></title>
	<link type="text/css" rel="stylesheet" href="../../../public/css/reset.css">
	<link type="text/css" rel="stylesheet" href="../../../public/css/main.css">
</head>
<body>
    <?php /*echo '<pre>';
        var_dump($_SESSION);
        echo '</pre>';
    */?>
    <?php /*echo '<pre>';
        var_dump($global_params['paginate']);
        echo '</pre>';*/
    ?>
<div class="container">
	<header>
	<div class="wrap_h">
		<h1>Главная страница</h1>
	</div>
	</header>
	<div class="main">
	<div class="content">
        <div class="link_home">

            <p>Приветствую <?php echo $global_params['current_user']; ?></p>
            <?php
                if ($global_params['current_user'] == 'Гость') {
                    ?>
                    <p>Вы можете <a class="link" href="views/signup.php">зарегистрировать</a> или
                        <a class="link" href="views/login.php">авторизироватся</a></p>
                    <?php
                } else {
                    ?>
                    <a class="link" href="views/logout.php">Выйти</a>
                    <?php
                }
            ?>
        </div>
		<p ><?php echo $global_params['page']['content']; ?></p>

	</div>
        <div class="col-lg">
            <h2>Коментарии</h2>
            <div id="hidden_block"><?php  echo $global_params['page']['page_id']; ?></div>
        </div>
        <div class="col-lg">
            <table>
                <thead>
                    <tr>
                        <th class="head_table" data-type="text">Имя</th>
                        <th class="head_table" data-type="text">E-mail</th>
                        <th class="head_table" data-type="text">Комментарий</th>
                        <th class="head_table" data-type="text">Домашняя страница</th>
                        <th class="head_table" data-type="date">Дата добавления</th>
                        <th class="head_table" data-type="none">Редактировать</th>
                        <th class="head_table" data-type="none">Удалить</th>
                    </tr>
                </thead>
                <tbody id="table">
            <?php
            foreach ($global_params['comments'] as $row) { ?>
                <tr>
                    <th><?php echo $row['user_name'];?></th>
                    <th><?php echo $row['e_mail']; ?></th>
                    <th><?php echo $row['comment'];?></th>
                    <th><?php echo $row['home_page']; ?></th>
                    <th><?php echo $row['created_at']; ?></th>
                    <?php
                    if ($row['access_open'] === true) { ?>
                        <th><div class="img_edit" data_rec="<?php echo $row['id']; ?>">
                            <a href="views/edit.php?id=<?php echo $row['id']; ?>"><img src="public/img/edit.png"></a></div></th>
                        <th><div class="img_delete" data_rec="<?php echo $row['id']; ?>"><img src="public/img/delete.jpg"></div></th>
                    <?php
                    } else { ?>
                        <th></th>
                        <th></th>
                    <?php }?>
                </tr>

            <?php } ?>
                </tbody>
            </table>
        </div>

        <div class="paginate">
            <?php
            if ( isset($global_params['paginate']) ) {
               if( $global_params['paginate']['paginate'] ) {

                    echo $global_params['paginate']['paginate']['pred_page'];
                    echo $global_params['paginate']['paginate']['curr_page'];
                    echo $global_params['paginate']['paginate']['nex_page'];
                }
            }
            ?>
        </div>
        <div class="col-lg">
            <div class="inscription">
                <p>Добавить коментарий</p>
            </div>
            <form action="" method="POST">
                <?php
                if ($global_params['current_user'] !== 'Гость') {
                    $name = $global_params['current_user'];
                    $email = $global_params['user_email'];
                    $enable = 'readonly';
                } else {
                    $name = '';
                    $email = '';
                    $enable = '';
                }
                ?>
                <div class="field_block_left">
                    <label for="comment_name" class="l_name" id="comment_name">Имя</label>
                    <input type="text" class="i_name" id="f_name"
                    name="comment_name" placeholder="Обязательно" value="<?php echo $name; ?>" <?php echo $enable; ?>>
                </div>
                <div class="field_block_right">
                    <label for="comment_e_mail" class="l_name" id="comment_e_mail">E-mail</label>
                    <input type="email" class="i_name" id="f_email"
                    name="comment_e_mail" placeholder="Обязательно" value="<?php echo $email; ?>" <?php echo $enable; ?>>
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
    <script src="public/js/edit.js"></script>
    <script src="public/js/sort.js"></script>
</body>
</html>
