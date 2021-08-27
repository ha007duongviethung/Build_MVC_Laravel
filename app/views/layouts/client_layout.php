<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo (!empty($page_title)) ? $page_title : 'Home Website'; ?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo _WEB_ROOT; ?>/public/assets/clients/css/style.css">
</head>
<body>
	<?php
		$this->render('blocks/header');

		$this->render($content, $sub_content);

		$this->render('blocks/footer');
	?>

	<script src="<?php echo _WEB_ROOT; ?>/public/assets/clients/js/script.js"></script>
</body>
</html>
