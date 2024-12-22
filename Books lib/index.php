<?php
include 'koneksi.php';

// Ambil data kategori dari database
$categories = $conn->query("SELECT * FROM categories")->fetch_all(MYSQLI_ASSOC);

// Filter
$whereClause = "WHERE 1=1";
$params = array();
$paramTypes = "";

if (isset($_GET['category']) && !empty($_GET['category'])) {
    $category = $_GET['category'];
    $whereClause .= " AND category_id = ?";
    $params[] = $category;
    $paramTypes .= "i";
}
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $whereClause .= " AND (title LIKE ? OR author LIKE ? OR publisher LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
    $params[] = "%$search%";
    $paramTypes .= "sss";
}
if (isset($_GET['date']) && !empty($_GET['date'])) {
    $date = $_GET['date'];
    $whereClause .= " AND publication_date = ?";
    $params[] = $date;
    $paramTypes .= "s";
}

// Query untuk mengambil data buku dengan filter
$sql = "SELECT * FROM books $whereClause";
$stmt = $conn->prepare($sql);

// Bind parameters jika ada
if (!empty($params)) {
    $stmt->bind_param($paramTypes, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

// Ambil semua data buku dan simpan ke dalam array $books
if ($result->num_rows > 0) {
    $books = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $books = array();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Daftar Buku</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> 
</head>
<body>
  <div class="container">
    <h1>Daftar Buku</h1>

    <a href="create_book.php" class="btn btn-primary mb-3">Tambah Buku</a>
    <a href="categories.php" class="btn btn-secondary mb-3">Kelola Kategori</a>

    <form method="GET" action="">
      <div class="form-row">
        <div class="form-group col-md-4">
          <select class="form-control" name="category">
            <option value="">Semua Kategori</option>
            <?php foreach ($categories as $category): ?>
              <option value="<?php echo $category['id']; ?>" <?php if(isset($_GET['category']) && $_GET['category'] == $category['id']) echo 'selected'; ?>><?php echo $category['name']; ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="form-group col-md-4">
          <input type="text" class="form-control" name="search" placeholder="Cari judul, penulis, penerbit" value="<?php if(isset($_GET['search'])) echo $_GET['search']; ?>">
        </div>
        <div class="form-group col-md-3">
          <input type="date" class="form-control" name="date" value="<?php if(isset($_GET['date'])) echo $_GET['date']; ?>">
        </div>
        <div class="col-md-1">
          <button type="submit" class="btn btn-primary">Filter</button>
        </div>
      </div>
    </form>

    <table class="table table-striped table-bordered">
      <thead>
        <tr>
          <th>Judul</th>
          <th>Penulis</th>
          <th>Tanggal Terbit</th>
          <th>Penerbit</th>
          <th>Halaman</th>
          <th>Kategori</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($books as $book): ?>
          <tr>
            <td><?php echo $book['title']; ?></td>
            <td><?php echo $book['author']; ?></td>
            <td><?php echo $book['publication_date']; ?></td>
            <td><?php echo $book['publisher']; ?></td>
            <td><?php echo $book['pages']; ?></td>
            <td>
              <?php 
                $categoryId = $book['category_id'];
                $categorySql = "SELECT name FROM categories WHERE id = ?";
                $stmtCategory = $conn->prepare($categorySql);
                $stmtCategory->bind_param("i", $categoryId);
                $stmtCategory->execute();
                $categoryResult = $stmtCategory->get_result();
                if ($categoryResult->num_rows > 0) {
                  $categoryName = $categoryResult->fetch_assoc()['name'];
                  echo $categoryName; 
                } else {
                  echo "Kategori tidak ditemukan";
                }
              ?>
            </td>
            <td>
              <a href="edit_book.php?id=<?php echo $book['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
              <a href="delete_book.php?id=<?php echo $book['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin ingin menghapus buku ini?')">Hapus</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</body>
</html>