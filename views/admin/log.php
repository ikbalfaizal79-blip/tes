<h2>Log Aktivitas Sistem</h2>
<table border="1">
    <tr>
        <th>User</th>
        <th>Aksi</th>
        <th>Waktu</th>
    </tr>
    <?php
    // Contoh pengambilan data log
    $query = "SELECT log_aktivitas.*, users.username FROM log_aktivitas 
              JOIN users ON log_aktivitas.id_user = users.id_user ORDER BY waktu DESC";
    // Tampilkan dengan foreach/while
    ?>
</table>