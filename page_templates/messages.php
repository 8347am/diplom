
<?php

$userid = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$recipientid = filter_input(INPUT_GET, 'recipientid', FILTER_VALIDATE_INT);
$userdata = get_users(['id' => $userid], 1, 0)[0];
$recipientdata = get_users(['id' => $recipientid], 1, 0)[0];
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

<div id="message_box">
		<div id="message_style"> 
			<?php display_messages($userid, $recipientid,'<p>', '</p>'); ?> 
		</div>
		<div class="sending-message">
			<textarea ng-model="message"></textarea><button ng-click="sendmessage(<?php echo $userid . ',' . $recipientid; ?>, message)">отправить</button>
			<input type="radio" ng-model="language" value="text">Normal text
			<input type="radio" ng-model="language" value="php">php
			<input type="radio" ng-model="language" value="js">js
		</div>
</div>