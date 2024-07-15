<?php

declare(strict_types = 1);

namespace App\BookModule\Infrastructure;

use App\BookModule\Dto\CreateBookDto;
use App\BookModule\Entity\Book;
use App\BookModule\Exceptions\BookAlreadyExists;
use App\BookModule\Repository\BookRepository;
use App\BookModule\ValueObject\Author;
use App\BookModule\ValueObject\BookId;
use App\BookModule\ValueObject\Description;
use App\BookModule\ValueObject\Genre;
use App\BookModule\ValueObject\Price;
use App\BookModule\ValueObject\PublishDate;
use App\BookModule\ValueObject\Title;
use PDO;
use PDOStatement;

readonly class BookRepositoryImpl implements BookRepository {
	public function __construct(
		private PDO $pdo
	) {
	}

	public function createBook(CreateBookDto $newBook): void {
		$bookId = new BookId($newBook->getId());
		$book = $this->findBookById($bookId);

		if ($book !== null) {
			throw BookAlreadyExists::create('Book already exists');
		}

		$book = $this->getBookInstance(
			$newBook->getId(),
			$newBook->getAuthor(),
			$newBook->getTitle(),
			$newBook->getGenre(),
			$newBook->getDescription(),
			$newBook->getPrice(),
			$newBook->getPublishDate()
		);
		$stmt = $this->pdo->prepare(
			"INSERT INTO books (book_id, author, title, genre, description, price, publish_date)\n"
			. 'VALUES (:id, :author, :title, :genre, :description, :price, :publishDate)'
		);
		$stmt->execute($book->toArray());
	}

	public function findBookById(BookId $id): ?Book {
		$stmt = $this->pdo->prepare(
			'SELECT book_id, author, title, genre, description, price, publish_date FROM books WHERE book_id = :id'
		);
		$stmt->execute(['id' => $id->getValue()]);
		return $this->fetch($stmt);
	}

	public function findBookByTitle(Title $title): ?Book {
		$stmt = $this->pdo->prepare(
			'SELECT book_id, author, title, genre, description, price, publish_date FROM books WHERE title = :title'
		);
		$stmt->execute(['title' => $title->getValue()]);
		return $this->fetch($stmt);
	}

	/**
	 * @return array<Book>
	 */
	public function findBooksByAuthor(Author $author): array {
		$stmt = $this->pdo->prepare(
			'SELECT book_id, author, title, genre, description, price, publish_date FROM books WHERE author = :author'
		);
		$stmt->execute(['author' => $author->getValue()]);
		$books = $stmt->fetchAll(PDO::FETCH_FUNC, fn (...$args) => $this->getBookInstance(...$args));

		return $books;
	}

	private function fetch(PDOStatement $stmt): ?Book {
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		\assert(\is_array($row) || $row === false, 'Unexpected fetch result');

		if ($row === false) {
			return null;
		}

		return $this->getBookInstance(
			$row['book_id'],
			$row['author'],
			$row['title'],
			$row['genre'],
			$row['description'],
			$row['price'],
			$row['publish_date']
		);
	}

	private function getBookInstance(
		string $bookId,
		string $author,
		string $title,
		string $genre,
		string $description,
		float $price,
		string $publishDate
	): Book {
		$bookIdVO = new BookId($bookId);
		$authorVO = new Author($author);
		$titleVO = new Title($title);
		$genreVO = new Genre($genre);
		$descriptionVO = new Description($description);
		$priceVO = new Price($price);
		$publishDateVO = new PublishDate($publishDate);

		return new Book($bookIdVO, $authorVO, $titleVO, $genreVO, $descriptionVO, $priceVO, $publishDateVO);
	}
}
