<?php
	require_once('init.php');
	$data = $_POST;
	switch ($data['action']){
		case 'send_message': 
		if (send_message($data['userid'], $data['recipientid'], $data['message'], $data['language'])){
			echo json_encode(['success' => true, 'data' => $data, 'files' => $_FILES]) ;
			die();
		} else{
			echo json_encode(['success' => false, 'data' => $data, 'files' => $_FILES]);
			die();
		}
		break;
		case 'get_messages':
		if ($current_user==null){
			echo json_encode(['success' => false]) ;
			die();
		}else{
			ob_start();
			display_messages($current_user['id'], $_POST['recipient'], '<p>', '</p>');
			$messages = ob_get_clean();
			echo json_encode(['success' => true, 'messages' => $messages]) ;
			die();
		}
		break;
	}
	
?>