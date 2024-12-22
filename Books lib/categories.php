<?php
include 'koneksi.php';

// Ambil data kategori dari database
$categories = $conn->query("SELECT * FROM categories")->fetch_all(MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html>
<head>
  <title>Kelola Kategori</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> 
</head>
<body>
  <div class="container">
    <h1>Kelola Kategori</h1>

    <a href="create_category.php" class="btn btn-primary mb-3">Tambah Kategori</a>
    <a href="index.php" class="btn btn-secondary mb-3">Kembali ke Daftar Buku</a> <div class="row">
        <div class="col-md-12">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Nama Kategori</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $category): ?>
                    <tr>
                        <td>
                            <?php echo $category['name']; ?>
                        </td>
                        <td>
                            <a href="edit_category.php?id=<?php echo $category['id']; ?>"
                                class="btn btn-warning btn-sm">Edit</a>
                            <a href="delete_category.php?id=<?php echo $category['id']; ?>"
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('Anda yakin ingin menghapus kategori ini?')">Hapus</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

  </div>
</body>
</html>