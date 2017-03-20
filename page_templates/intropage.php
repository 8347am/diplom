
<div id="welcome">
<h2>Добро пожаловать, <span><?php echo $_SESSION['session_username'];?>! </span></h2>
  <p><a href="<?php echo get_page_url('logout'); ?>">Выйти</a> из системы или <?php echo '<a href="' . get_page_url('profile') . '&id=' . $current_user['id'] . '">Войти в профиль</a>'; ?></p>
</div>