<?php
require_once 'Book.php';
require_once 'Library.php';

// Membuat objek buku dan perpustakaan
$book1 = new Book("Judul Buku 1", "Penulis 1", 2000);
$book2 = new Book("Judul Buku 2", "Penulis 2", 2010);
$library = new Library();
$library->addBook($book1);
$library->addBook($book2);

// Interaksi dengan user interface
if (isset($_POST['action'])) {
    $action = $_POST['action'];
    switch ($action) {
        case 'tambah':
            $judul = $_POST['judul'];
            $penulis = $_POST['penulis'];
            $tahun = $_POST['tahun'];
            $book = new Book($judul, $penulis, $tahun);
            $library->addBook($book);
            break;
        case 'pinjam':
            $judul = $_POST['judul'];
            $result = $library->borrowBook($judul);
            if ($result) {
                echo "Buku berhasil dipinjam.";
            } else {
                echo "Buku tidak tersedia atau sudah dipinjam.";
            }
            break;
        case 'kembali':
            $judul = $_POST['judul'];
            $result = $library->returnBook($judul);
            if ($result) {
                echo "Buku berhasil dikembalikan.";
            } else {
                echo "Buku tidak ditemukan atau tidak sedang dipinjam.";
            }
            break;
	case 'cari':
            $keyword = $_POST['keyword'];
            $searchResult = $library->searchBook($keyword);
            if (count($searchResult) > 0) {
                echo "<h2>Hasil Pencarian</h2>";
                echo "<ul>";
            foreach ($searchResult as $book) {
                echo "<li>{$book->getTitle()} ({$book->getAuthor()}, {$book->getYear()})</li>";
            }
            echo "</ul>";
            } else {
                echo "<p>Tidak ada hasil ditemukan untuk kata kunci '$keyword'.</p>";
            }
            break;
        case 'urut':
            $criteria = $_POST['criteria'];
            $sortedBooks = $library->sortBooks($criteria);
            echo "<h2>Daftar Buku Setelah Diurutkan</h2>";
            echo "<ul>";
            foreach ($sortedBooks as $book) {
                echo "<li>{$book->getTitle()} ({$book->getAuthor()}, {$book->getYear()})</li>";
            }
            echo "</ul>";
            break;            
        case 'hapus':
           $judul_hapus = $_POST['judul_hapus'];
           $result = $library->removeBook($judul_hapus);
           if ($result) {
               echo "Buku berhasil dihapus dari koleksi.";
           } else {
               echo "Buku tidak ditemukan dalam koleksi.";
           }
           break;
    }
}

// Tampilkan form dan daftar buku
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan by Hilmansyah || NPM : 20552011267</title>
</head>
<body>
    <h1>Perpustakaan by Hilmansyah || NPM : 20552011267</h1>
    <h2>Daftar Buku Tersedia</h2>
    <ul>
        <?php
        $availableBooks = $library->listAvailableBooks();
        foreach ($availableBooks as $book) {
            echo "<li>{$book->getTitle()} ({$book->getAuthor()}, {$book->getYear()})</li>";
        }
        ?>
    </ul>
    <h2>Tambah Buku Baru</h2>
    <form method="post">
        <label for="judul">Judul:</label><br>
        <input type="text" id="judul" name="judul"><br>
        <label for="penulis">Penulis:</label><br>
        <input type="text" id="penulis" name="penulis"><br>
        <label for="tahun">Tahun Terbit:</label><br>
        <input type="number" id="tahun" name="tahun"><br><br>
        <input type="hidden" name="action" value="tambah">
        <input type="submit" value="Tambah">
    </form>
    <h2>Pinjam Buku</h2>
    <form method="post">
        <label for="judul_pinjam">Judul:</label><br>
        <input type="text" id="judul_pinjam" name="judul"><br><br>
        <input type="hidden" name="action" value="pinjam">
        <input type="submit" value="Pinjam">
    </form>
    <h2>Kembalikan Buku</h2>
    <form method="post">
        <label for="judul_kembali">Judul:</label><br>
        <input type="text" id="judul_kembali" name="judul"><br><br>
        <input type="hidden" name="action" value="kembali">
        <input type="submit" value="Kembalikan">
    </form>
    <h2>Daftar Buku Tersedia</h2>
    <table border="1">
    <tr>
        <th>Judul</th>
        <th>Penulis</th>
        <th>Tahun Terbit</th>
    </tr>
    <?php
    $availableBooks = $library->listAvailableBooks();
    foreach ($availableBooks as $book) {
        echo "<tr>";
        echo "<td>{$book->getTitle()}</td>";
        echo "<td>{$book->getAuthor()}</td>";
        echo "<td>{$book->getYear()}</td>";
        echo "</tr>";
    }
    ?>
    </table>
    <h2>Cari Buku</h2>
    <form method="post">
        <label for="keyword">Kata Kunci:</label><br>
        <input type="text" id="keyword" name="keyword"><br><br>
        <input type="hidden" name="action" value="cari">
        <input type="submit" value="Cari">
    </form>
    <h2>Urutkan Daftar Buku</h2>
    <form method="post">
        <label for="criteria">Pilih Kriteria:</label><br>
        <select name="criteria" id="criteria">
            <option value="year">Tahun Terbit</option>
            <option value="author">Penulis</option>
        </select><br><br>
        <input type="hidden" name="action" value="urut">
        <input type="submit" value="Urutkan">
    </form>
    <h2>Hapus Buku dari Koleksi</h2>
    <form method="post">
        <label for="judul_hapus">Judul:</label><br>
        <input type="text" id="judul_hapus" name="judul_hapus"><br><br>
        <input type="hidden" name="action" value="hapus">
        <input type="submit" value="Hapus">
    </form>

</body>
</html>