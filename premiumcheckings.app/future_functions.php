<?php
function validatePassword($password) {
    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number = preg_match('@[0-9]@', $password);
    $specialChars = preg_match('@[^\w]@', $password);
    $length = strlen($password);
    if(!$uppercase || !$lowercase || !$number || !$specialChars || $length < 8) {
        return false;
    }
    return true;
}
    