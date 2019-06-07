<?php 



$var = new stdClass();
var_dump(spl_object_hash($var), spl_object_hash(new stdClass()));

hola();

function hola() {
    $var = new stdClass();
    var_dump(spl_object_hash($var), spl_object_hash(new stdClass()));
}


 ?>