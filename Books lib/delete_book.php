<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk menghapus data buku dari database
    $sql = "DELETE FROM books WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "Buku berhasil dihapus!";
        // Redirect ke halaman daftar buku
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "ID buku tidak valid!";
}
?>