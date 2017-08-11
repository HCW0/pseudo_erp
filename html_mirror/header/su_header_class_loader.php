<?php


// include function
     function my_autoloader($class){
         include $_SERVER['DOCUMENT_ROOT']."/classes/".$class.'.php';
    }
	spl_autoload_register('my_autoloader');
?>
