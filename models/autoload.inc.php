<?php 

function class_autoload($class){
  include_once($class . ".class.php");
}
//-------------------------------------------------

spl_autoload_register("class_autoload");