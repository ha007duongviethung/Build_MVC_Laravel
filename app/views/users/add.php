<?php 
	echo (!empty($msg) ? $msg : false);
	HtmlHelper::formOpen('post', _WEB_ROOT.'/home/post_user');
	HtmlHelper::input('<div>', form_error('fullname', '<span style="color: red">', '</span>').'</div>', 'text', 'fullname', '', '', 'FullName...', old('fullname'));
	HtmlHelper::input('<div>', form_error('age', '<span style="color: red">', '</span>').'</div>', 'number', 'age', '', '', 'Age...', old('age'));
	HtmlHelper::input('<div>', form_error('email', '<span style="color: red">', '</span>').'</div>', 'email', 'email', '', '', 'Email...', old('email'));
	HtmlHelper::input('<div>', form_error('password', '<span style="color: red">', '</span>').'</div>', 'password', 'password', '', '', 'Password...');
	HtmlHelper::input('<div>', form_error('comfirm_password', '<span style="color: red">', '</span>').'</div>', 'password', 'comfirm_password', '', '', 'Comfirm Password...');
	HtmlHelper::submit('Submit');
	HtmlHelper::formClose();
?>