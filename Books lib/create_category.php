<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];

    // Validasi input
    if (empty($name)) {
        echo "Nama kategori harus diisi!";
    } else {
        // Query untuk menyimpan data kategori ke database
        $sql = "INSERT INTO categories (name) VALUES ('$name')";

        if ($conn->query($sql) === TRUE) {
            echo "Kategori berhasil ditambahkan!";
            header("Location: categories.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Tambah Kategori</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> 
</head>
<body>
  <div class="container">
    <h1>Tambah Kategori</h1>
    <form method="POST" action="">
      <div class="form-group">
        <label for="name">Nama Kategori:</label>
        <input type="text" class="form-control" id="name" name="name" required>
      </div>
      <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
  </div>
</body>
</html>