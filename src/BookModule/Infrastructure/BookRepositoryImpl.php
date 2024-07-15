<?php

declare(strict_types = 1);

namespace App\BookModule\Infrastructure;

use App\BookModule\Dto\CreateBookDto;
use App\BookModule\Dto\UpdateBookDto;
use App\BookModule\Entity\Book;
use App\BookModule\Exceptions\BookAlreadyExists;
use App\BookModule\Exceptions\BookNotFound;
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
	private const SELECT_FROM = 'SELECT book_id, author, title, genre, description, price, publish_date FROM books';

	public function __construct(
		private PDO $pdo
	) {
	}

	public function create(CreateBookDto $newBookDto): Book {
		$bookId = new BookId($newBookDto->getId());
		$book = $this->findBookById($bookId);

		if ($book !== null) {
			throw BookAlreadyExists::create('Book already exists');
		}

		$book = $this->getBookInstance(
			$newBookDto->getId(),
			$newBookDto->getAuthor(),
			$newBookDto->getTitle(),
			$newBookDto->getGenre(),
			$newBookDto->getDescription(),
			$newBookDto->getPrice(),
			$newBookDto->getPublishDate()
		);
		$stmt = $this->pdo->prepare(
			"INSERT INTO books (book_id, author, title, genre, description, price, publish_date)\n"
			. 'VALUES (:id, :author, :title, :genre, :description, :price, :publish_date)'
		);
		$stmt->execute($book->toArray());

		return $book;
	}

	public function delete(BookId $id): void {
		$stmt = $this->pdo->prepare('DELETE FROM books WHERE book_id = :id');
		$stmt->execute(['id' => $id->getValue()]);
	}

	public function findBookById(BookId $id): ?Book {
		$stmt = $this->pdo->prepare(self::SELECT_FROM . ' WHERE book_id = :id');
		$stmt->execute(['id' => $id->getValue()]);
		return $this->fetch($stmt);
	}

	public function findBookByTitle(Title $title): ?Book {
		$stmt = $this->pdo->prepare(self::SELECT_FROM . ' WHERE title = :title');
		$stmt->execute(['title' => $title->getValue()]);
		return $this->fetch($stmt);
	}

	/**
	 * @return array<Book>
	 */
	public function findBooksByAuthor(Author $author): array {
		$stmt = $this->pdo->prepare(self::SELECT_FROM . ' WHERE author = :author');
		$stmt->execute(['author' => $author->getValue()]);
		$books = $stmt->fetchAll(PDO::FETCH_FUNC, fn (...$args) => $this->getBookInstance(...$args));

		return $books;
	}

	/**
	 * @return array<Book>
	 */
	public function getAll(): array {
		$stmt = $this->pdo->query(self::SELECT_FROM);
		$books = $stmt->fetchAll(PDO::FETCH_FUNC, fn (...$args) => $this->getBookInstance(...$args));

		return $books;
	}

	public function update(BookId $id, UpdateBookDto $updateBookDto): Book {
		$stmt = $this->pdo->prepare(
			"UPDATE books\n"
			. "SET author = :author, title = :title, genre = :genre, description = :description, price = :price, publish_date = :publish_date\n"
			. 'WHERE book_id = :id'
		);
		$stmt->execute($updateBookDto->toArray());

		if ($stmt->rowCount() === 0) {
			throw BookNotFound::create('Book not found');
		}

		return $this->getBookInstance(
			$id->getValue(),
			$updateBookDto->getAuthor(),
			$updateBookDto->getTitle(),
			$updateBookDto->getGenre(),
			$updateBookDto->getDescription(),
			$updateBookDto->getPrice(),
			$updateBookDto->getPublishDate()
		);
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
