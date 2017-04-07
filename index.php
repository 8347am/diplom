<?php
	require_once('init.php');
	get_header();
	$page = filter_input(INPUT_GET, 'page');
	if ($page){
		include(SITE_DIR . '/page_templates/' . $page .'.php');
	} else {
		include(DEFAULT_PAGE);
	}
	get_footer();
?>