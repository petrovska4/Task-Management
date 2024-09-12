<?php

$db = new Mysqli;

$db->connect('localhost', 'root', '', 'task_management');

if(!$db) {
  echo "success";
}

?>