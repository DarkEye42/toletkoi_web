<?php
$password = $_POST['password'];

$length = strlen($password);
$uppercase = preg_match('@[A-Z]@', $password);
$lowercase = preg_match('@[a-z]@', $password);
$number    = preg_match('@[0-9]@', $password);
$specialChars = preg_match('@[^\w]@', $password);

if ($length < 8 || (!$uppercase && !$lowercase) || !$number) {
    echo '<span style="color: red;">Weak password</span>';
} elseif ($length >= 8 && $length < 12 && ($uppercase || $lowercase) && $number) {
    echo '<span style="color: orange;">Medium password</span>';
} else {
    echo '<span style="color: green;">Strong password</span>';
}
?>