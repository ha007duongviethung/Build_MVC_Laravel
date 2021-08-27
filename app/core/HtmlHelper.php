<?php

/**
 * 
 */
class HtmlHelper
{
	public static function formOpen($method='get', $action='') {
		echo '
			<form method="'.$method.'" action="'.$action.'" >
		';
	}	

	public static function formClose() {
		echo '</form>';
	}

	public static function input($wrapBefore='', $wrapAfter='', $type='text', $name, $class='', $id='', $placeholder='', $value='') {
		echo $wrapBefore;
		echo ' 
			<input type="'.$type.'" name="'.$name.'" class="'.$class.'" id="'.$id.'" placeholder="'.$placeholder.'" value="'.$value.'">
		';
		echo $wrapAfter;
	} 

	public static function submit($lable, $class='') {
		echo '<button type="submit" class="'.$class.'">' . $lable . '</button>';
	} 
}