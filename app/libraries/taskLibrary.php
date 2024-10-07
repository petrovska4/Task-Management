<?php
class TaskLibrary {
  public static function validateDates($dateTime) {
    $inputDateTime = new DateTime($dateTime);
    
    $currentDateTime = new DateTime();

    if ($inputDateTime > $currentDateTime) {
        return true; 
    } else {
        return false; 
    }
}
}
?>