<?php
// Jalankan file ini sekali saja, lalu copy hasil hash ke database
$hash = password_hash('maxrumbo', PASSWORD_DEFAULT);
echo $hash;
?>
