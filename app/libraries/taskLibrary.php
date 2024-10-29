<?php
class TaskLibrary {
    public static function validateDates($dateTime) {
        $inputDateTime = new DateTime($dateTime);
        $currentDateTime = new DateTime();

        return $inputDateTime > $currentDateTime;
    }
}
?>
