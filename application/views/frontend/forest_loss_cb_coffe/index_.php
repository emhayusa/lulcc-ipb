<?php
	if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
		$uri = 'https://';
	} else {
		$uri = 'http://';
	}
	$uri .= $_SERVER['HTTP_HOST'];
	$url_link=$uri.'/webapp/forest_loss_change_by_coffe/';
?>

<iframe style="border: 0px none; margin-left: 0px; height: 750px; margin-top: 0px; width: 100%;" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" 
src="https://localhost/webapp/forest_loss_change_by_coffe/">
<!-- src="<? //php echo $url_link; ?>"> -->
</iframe>