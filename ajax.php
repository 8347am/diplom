<?php
	require_once('init.php');
	$data = $_POST;
	switch ($data['action']){
		case 'send_message': 
		if (send_message($data['userid'], $data['recipientid'], $data['message'], $data['language'])){
			echo json_encode(['success' => true, 'data' => $data]) ;
		} else{
			echo json_encode(['success' => false, 'data' => $data]);
		}
		break;
	}
?>