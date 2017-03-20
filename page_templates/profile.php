
<?php

$userid = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$userdata = get_users(['id' => $userid], 1, 0)[0];
?>
<?php

?>
<div id="userInfo">
	<img id="ava" src="">
	<p><?php echo $userdata['name'],' ', $userdata['subname']; ?></p>
	<?php if (is_friend($current_user['id'], $userid)): ?>
	<p><a href="<?php echo get_page_url('remove-friend'); ?>&friend_id=<?php echo $userid; ?>">Удалить друга</a></p>
	<?php else : ?>
	<p><a href="<?php echo get_page_url('add-friend'); ?>&friend_id=<?php echo $userid; ?>">Добавить в друзья</a></p>
	<?php endif; ?>
	<p><a href="<?php echo get_page_url('messages') . '&id=' . $current_user['id'] . '&recipientid=' . $userid; ?>">Сообщения</a></p>
	<p><a href="<?php echo get_page_url('friendlist') . '&id=' . $current_user['id'];?>">Друзья</a></p>
</div>

