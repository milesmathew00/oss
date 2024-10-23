<?php
$plain_password = 'your_test_password';
$hashed_password = password_hash($plain_password, PASSWORD_BCRYPT);
echo "Plain password: $plain_password<br>";
echo "Hashed password: $hashed_password<br>";

if (password_verify($plain_password, $hashed_password)) {
    echo "Password is valid!";
} else {
    echo "Password is invalid.";
}
?>
