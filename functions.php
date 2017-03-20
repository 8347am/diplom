<?php
include_once 'templates/geshi.php';
 

function get_header(){
	global $current_user;
	include_once(SITE_DIR . '\templates\header.php');
}
function get_footer(){
	include_once(SITE_DIR . '\templates\footer.php');
}
function get_page_url($page){
	return SITE_URL . 'index.php?page=' . $page;
}
function redirect($page){
	header("location: index.php?page=" . $page);
}
function redirect_url($url){
	header("location: " . $url);
}
function query_get_assoc($query){
	$result = mysql_query($query);
	if ($result){
		$array = [];
		while($row = mysql_fetch_assoc($result)){
			$array[] = $row;
		}
		return $array;
	} else return false;
}
function get_users($filter = [], $limit = 30, $offset = 0){
	$query="SELECT * FROM usertbl ";
	if (!empty($filter)){
		$query .= ' WHERE ';
		$prev = null;
		foreach($filter as $key => $value){
			if ($value != null){
				if ($prev != null) {
					$query .= ' AND ';
				}
				$prev = $value;
				$query .= $key . ' = "' . $value . '"';
			}
		}
	}
	$query .= ' LIMIT ' . $limit;
	$query .= ' OFFSET ' . $offset;
	return query_get_assoc($query);
}
function get_user_url($id){
	return get_page_url('profile') . '&id=' . $id;
}
function display_users($users = [], $before = '', $after = ''){
	foreach($users as $user){
		echo $before .'<a href="' . get_user_url($user['id']) . '">' . $user['name'] . ' ' . $user['subname'] . '</a>' . $after;
	}
}
function add_friend($userid, $friend){
	$result = mysql_query("INSERT INTO contacts (userid, contactid) VALUES($userid, $friend)");
}
function remove_friend($userid, $friend){
	$result = mysql_query("DELETE FROM contacts WHERE userid=$userid AND contactid=$friend");
}
function is_friend($userid, $friend){
	$result = mysql_query("SELECT * FROM contacts WHERE userid=$userid AND contactid=$friend LIMIT 1");
	$row = mysql_fetch_assoc($result);
	if (!empty($row)){
		return true;
	} else {
		return false;
	}
}
function display_fiends($userid = 0, $before = '', $after = '', $label = 'Список друзей'){
	if ($userid == 0) return false;
	$users = query_get_assoc("SELECT * FROM contacts LEFT JOIN usertbl on contactid = id WHERE userid = $userid");
	echo '<p>' . $label . '</p>';
	display_users($users, $before, $after);
}
function display_messages($userid = 0, $recipientid = 0, $before = '', $after = '', $label = 'Сообщения'){
	if ($userid == 0) return false;
	$messages = query_get_assoc("SELECT * FROM messages LEFT JOIN file ON messages.id = file.parent_mess LEFT JOIN usertbl U ON userid = U.id WHERE userid = $userid AND recipientid = $recipientid OR userid = $recipientid AND recipientid = $userid ORDER BY date(created)");
	echo '<p>' . $label . '</p>';
	foreach($messages as $message){
		$source = $message['message'];
		$language = ($message['lang']) ? $message['lang'] : 'text';
		echo $before .'<a href="' . get_user_url($message['userid']) . '">' . $message['name'] . ' ' . $message['subname'] . '</a>';
		if (isset($message['path'])){
			echo '<a href="' . SITE_URL . '/uploads/' .basename($message['path']) . '">' . basename($message['path']) . '</a>';
		}
		if ($language == 'text'){
			echo $message['message'];
		} else {
			$geshi = new GeSHi($source, $language);
			echo '<div class="code">';
			echo '<span class="lang">' . $language . '</span>';
			echo $geshi->parse_code();
			echo '</div>';
		}
		echo $after;
		
	}
}
function send_message($userid = 0, $recipientid = 0, $message = '', $language = "text"){
	$message = addslashes($message);
	$language = addslashes($language);
	$result = mysql_query("INSERT INTO messages (userid, recipientid, message, lang) VALUES ($userid, $recipientid, '$message', '$language')");
	if (mysql_affected_rows()>0){
		$messageid=mysql_insert_id();
		send_file($userid, $messageid);
	}
	if ($result) return true;
	return false;
}
function send_file($userid, $messageid) {
	if (isset($_FILES['fileUpload'])){
		$uploaddir = SITE_DIR .'/uploads/';
		$uploadfile = $uploaddir . basename($_FILES['fileUpload']['name']);
		if (!move_uploaded_file($_FILES['fileUpload']['tmp_name'], $uploadfile)) {
			return false;
		} else {
			$result = mysql_query("INSERT INTO file (parent_user, parent_mess, path, type) VALUES ($userid, $messageid, '$uploadfile', 'file')");
			if ($result) return true;
			return false;
		}
	}
	return false;

}