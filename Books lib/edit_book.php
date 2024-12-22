<?php
include 'koneksi.php';

// Ambil data kategori dari database
$categories = $conn->query("SELECT * FROM categories")->fetch_all(MYSQLI_ASSOC);

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil data buku dari database berdasarkan ID
    $sql = "SELECT * FROM books WHERE id = $id";
    $result = $conn->query($sql);
    $book = $result->fetch_assoc();

    if ($book) {
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
                // Query untuk mengupdate data buku di database
                $sql = "UPDATE books SET 
                        title='$title', 
                        author='$author', 
                        publication_date='$publication_date', 
                        publisher='$publisher', 
                        pages='$pages', 
                        category_id='$category_id' 
                        WHERE id=$id";

                if ($conn->query($sql) === TRUE) {
                    echo "Buku berhasil diupdate!";
                    // Redirect ke halaman daftar buku
                    header("Location: index.php");
                    exit();
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
        }
    } else {
        echo "Buku tidak ditemukan!";
    }
} else {
    echo "ID buku tidak valid!";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Buku</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> 
</head>
<body>
    <div class="container">
        <h1>Edit Buku</h1>
        <?php if ($book): ?>
        <form method="POST" action="">
            <div class="form-group">
                <label for="title">Judul:</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo $book['title']; ?>" required>
            </div>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>