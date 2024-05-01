<?php

// Book.php

class Book {
    protected $title;
    protected $author;
    protected $year;
    protected $isBorrowed;

    public function __construct($title, $author, $year) {
        $this->title = $title;
        $this->author = $author;
        $this->year = $year;
        $this->isBorrowed = false;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getAuthor() {
        return $this->author;
    }

    public function getYear() {
        return $this->year;
    }

    public function isBorrowed() {
        return $this->isBorrowed;
    }

    public function borrow() {
        if (!$this->isBorrowed) {
            $this->isBorrowed = true;
            return true; // Berhasil meminjam
        } else {
            return false; // Gagal meminjam
        }
    }

    public function returnBook() {
        if ($this->isBorrowed) {
            $this->isBorrowed = false;
            return true; // Berhasil mengembalikan
        } else {
            return false; // Buku sudah tersedia
        }
    }
}

class ReferenceBook extends Book {
    private $isbn;
    private $publisher;

    public function __construct($title, $author, $year, $isbn, $publisher) {
        parent::__construct($title, $author, $year);
        $this->isbn = $isbn;
        $this->publisher = $publisher;
    }

    public function getISBN() {
        return $this->isbn;
    }

    public function getPublisher() {
        return $this->publisher;
    }
}

?>