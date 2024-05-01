<?php

class Library {
    private $books = [];

    public function addBook($book) {
        $this->books[] = $book;
    }

    public function borrowBook($title) {
        foreach ($this->books as $book) {
            if ($book->getTitle() == $title && !$book->isBorrowed()) {
                return $book->borrow();
            }
        }
        return false; // Buku tidak ditemukan atau sudah dipinjam
    }

    public function returnBook($title) {
        foreach ($this->books as $book) {
            if ($book->getTitle() == $title && $book->isBorrowed()) {
                return $book->returnBook();
            }
        }
        return false; // Buku tidak ditemukan atau sudah dikembalikan
    }

    public function listAvailableBooks() {
        $availableBooks = [];
        foreach ($this->books as $book) {
            if (!$book->isBorrowed()) {
                $availableBooks[] = $book;
            }
        }
        return $availableBooks;
    }

    public function searchBook($keyword) {
        $foundBooks = [];
        foreach ($this->books as $book) {
            if (stripos($book->getTitle(), $keyword) !== false || stripos($book->getAuthor(), $keyword) !== false) {
                $foundBooks[] = $book;
            }
        }
        return $foundBooks;
    }

    public function sortBooks($criteria) {
        $sortedBooks = $this->books;
        usort($sortedBooks, function ($a, $b) use ($criteria) {
            if ($criteria == 'year') {
                return $a->getYear() - $b->getYear();
            } elseif ($criteria == 'author') {
                return strcmp($a->getAuthor(), $b->getAuthor());
            }
            return 0;
        });
        return $sortedBooks;
    }

    public function calculateLateFine($returnDate) {
        // Implementasi
    }

    public function removeBook($title) {
        foreach ($this->books as $key => $book) {
            if ($book->getTitle() == $title) {
                unset($this->books[$key]);
                return true; // Buku berhasil dihapus
            }
        }
        return false; // Buku tidak ditemukan
    }
}

?>