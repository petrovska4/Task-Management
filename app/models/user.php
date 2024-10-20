<?php

function get_user($user_id) {
  global $db;
  $query = 'SELECT * FROM user WHERE id = ?';
  $statement = $db ->prepare($query);

  $statement->bind_param("i", $user_id);
  $statement->execute();
  $result = $statement->get_result();
  $user = $result->fetch_assoc();
  $statement->close();

  return $user;
}


?>