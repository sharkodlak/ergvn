<?php

declare(strict_types = 1);

namespace App\BookModule\Service;

use App\BookModule\Dto\CreateBookDto;
use App\BookModule\Entity\Book;
use App\BookModule\Exceptions\BookNotFound;
use App\BookModule\Repository\BookRepository;
use App\BookModule\ValueObject\BookId;

class BookCrudService {
	public function __construct(
		private readonly BookRepository $bookRepository
	) {
	}

	public function createBook(CreateBookDto $newBookDto): Book {
		return $this->bookRepository->create($newBookDto);
	}

	public function deleteBook(BookId $id): void {
		$this->bookRepository->delete($id);
	}

	public function getBook(BookId $id): Book {
		$book = $this->bookRepository->findBookById($id);

		if ($book === null) {
			throw BookNotFound::create();
		}

		return $book;
	}

	/**
	 * @return array<Book>
	 */
	public function getBooks(): array {
		return $this->bookRepository->getAll();
	}

	public function updateBook(BookId $id, CreateBookDto $updateBookDto): Book {
		return $this->bookRepository->update($id, $updateBookDto);
	}
}
