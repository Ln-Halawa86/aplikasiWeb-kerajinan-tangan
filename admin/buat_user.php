<?php
// --- GANTI DATA DI BAWAH INI ---
$username_baru = "budi";
$password_polos = "BudiSukaBakso"; // Ganti dengan password yang kuat
$nama_lengkap = "Budi Santoso";
// --------------------------------

// Membuat hash yang aman dari password
$hashed_password = password_hash($password_polos, PASSWORD_DEFAULT);

// Menyiapkan query SQL yang siap pakai
$sql_query = "INSERT INTO user (username, password, nama) VALUES ('$username_baru', '$hashed_password', '$nama_lengkap');";

echo "<h3>Data User Baru Siap Dimasukkan!</h3>";
echo "<p>Silakan salin query SQL di bawah ini dan jalankan di phpMyAdmin.</p>";
echo '<textarea rows="5" cols="80" onclick="this.select();" readonly>' . htmlspecialchars($sql_query) . '</textarea>';

?>