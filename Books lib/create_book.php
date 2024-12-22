<?php
include 'koneksi.php';

// Ambil data kategori dari database
$categories = $conn->query("SELECT * FROM categories")->fetch_all(MYSQLI_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $publication_date = $_POST['publication_date'];
    $publisher = $_POST['publisher'];
    $pages = $_POST['pages'];
    $category_id = $_POST['category_id'];

    // Validasi input (tambahkan validasi sesuai kebutuhan)
    if (empty($title) || empty($author) || empty($publication_date) || empty($publisher) || empty($pages) || empty($category_id)) {
        echo "Semua field harus diisi!";
    } else {
        // Query untuk menyimpan data buku ke database
        $sql = "INSERT INTO books (title, author, publication_date, publisher, pages, category_id) 
                VALUES ('$title', '$author', '$publication_date', '$publisher', '$pages', '$category_id')";

        if ($conn->query($sql) === TRUE) {
            echo "Buku berhasil ditambahkan!";
            // Redirect ke halaman daftar buku
            header("Location: index.php");
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
    <title>Tambah Buku</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> 
</head>
<body>
    <div class="container">
        <h1>Tambah Buku</h1>

        <a href="index.php" class="btn btn-secondary mb-3">Kembali ke Daftar Buku</a>

        <form method="POST" action="">
            <div class="form-group">
                <label for="title">Judul:</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="author">Penulis:</label>
                <input type="text" class="form-control" id="author" name="author" required>
            </div>
            <div class="form-group">
                <label for="publication_date">Tanggal Terbit:</label>
                <input type="date" class="form-control" id="publication_date" name="publication_date" required>
            </div>
            <div class="form-group">
                <label for="publisher">Penerbit:</label>
                <input type="text" class="form-control" id="publisher" name="publisher" required>
            </div>
            <div class="form-group">
                <label for="pages">Jumlah Halaman:</label>
                <input type="number" class="form-control" id="pages" name="pages" required>
            </div>
            <div class="form-group">
                <label for="category_id">Kategori:</label>
                <select class="form-control" id="category_id" name="category_id" required>
                    <option value="">Pilih Kategori</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</body>
</html>