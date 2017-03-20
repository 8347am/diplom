
<?php 
$friend_id = filter_input(INPUT_GET, 'friend_id', FILTER_VALIDATE_INT);
if (!$current_user){
	echo 'Вы не авторизованны.';
} elseif ($friend_id == false){
	echo 'пользователь не найден.';
} else {
	add_friend($current_user['id'], $friend_id);
	redirect_url(get_user_url($friend_id));
}
?>
