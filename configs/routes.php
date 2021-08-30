<?php
$routes['default_controller'] = 'home';

/*
* Duong dan ao => Duong dan that
*/

$routes['san-pham'] = 'product/index';
$routes['trang-chu'] = 'home';
$routes['tin-tuc/.+-(\d+).html'] = 'news/category/$1';
$routes['chi-tiet-san-pham'] = 'product/detail';

?>