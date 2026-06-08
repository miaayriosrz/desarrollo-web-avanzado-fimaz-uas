<?php
$hash = password_hash('admin123', PASSWORD_DEFAULT);
echo $hash;
echo "\n";
echo "Longitud:" . strlen($hash); // debe ser 60
?>