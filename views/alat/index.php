<h2>Daftar Alat</h2>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Nama Alat</th>
        <th>Stok</th>
    </tr>
    <?php foreach ($data as $row): ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= $row['nama_alat'] ?></td>
        <td><?= $row['stok'] ?></td>
    </tr>
    <?php endforeach; ?>
</table>
