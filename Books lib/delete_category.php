<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk menghapus data kategori dari database
    $sql = "DELETE FROM categories WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "Kategori berhasil dihapus!";
        header("Location: categories.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "ID kategori tidak valid!";
}
?>