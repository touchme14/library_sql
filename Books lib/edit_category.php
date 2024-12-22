<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil data kategori dari database berdasarkan ID
    $sql = "SELECT * FROM categories WHERE id = $id";
    $result = $conn->query($sql);
    $category = $result->fetch_assoc();

    if ($category) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = $_POST['name'];

            // Validasi input
            if (empty($name)) {
                echo "Nama kategori harus diisi!";
            } else {
                // Query untuk mengupdate data kategori di database
                $sql = "UPDATE categories SET name='$name' WHERE id=$id";

                if ($conn->query($sql) === TRUE) {
                    echo "Kategori berhasil diupdate!";
                    header("Location: categories.php");
                    exit();
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
        }
    } else {
        echo "Kategori tidak ditemukan!";
    }
} else {
    echo "ID kategori tidak valid!";
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Kategori</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> 
</head>
<body>
  <div class="container">
    <h1>Edit Kategori</h1>
    <?php if ($category): ?>
    <form method="POST" action="">
      <div class="form-group">
        <label for="name">Nama Kategori:</label>
        <input type="text" class="form-control" id="name" name="name" value="<?php echo $category['name']; ?>" required>
      </div>
      <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
    <?php endif; ?>
  </div>
</body>
</html>