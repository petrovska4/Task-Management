<?php

$db = new Mysqli;

$db->connect('localhost', 'root', '', 'task_management');

if ($db->connect_error) {
  die("Connection failed: " . $db->connect_error);
}
?>