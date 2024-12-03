<?php

$my_REQUEST = array();

foreach($A_INPUTVARS as $k => $v)
{
eval("\$_defined = isset(\$$v);");
if(!$_defined){
eval("\$my_REQUEST['$v'] = filter_input(INPUT_GET, \"$v\");");
if($my_REQUEST[$v]==""){
    eval("\$my_REQUEST['$v'] = filter_input(INPUT_POST, \"$v\");");
}
}
}
extract($my_REQUEST);

if(!isset($login)  || $login!='1')  { $login = 0; }
if(!isset($logout) || $logout!='1') { $logout = 0; }
if(!isset($username)) { $username = ""; }
if(!isset($tab)) { $tab = ""; }
if(!isset($tab2)) { $tab2 = ""; }

#var_dump($my_REQUEST);

?>