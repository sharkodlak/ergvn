<?php

declare(strict_types = 1);

namespace App\BookModule\Service;

use App\BookModule\Dto\CreateBookDto;
use App\BookModule\Entity\Book;
use App\BookModule\Repository\BookRepository;
use App\BookModule\ValueObject\BookId;

class BookCrudService {
	public function __construct(
		private readonly BookRepository $bookRepository
	) {
	}

	public function createBook(CreateBookDto $newBook): void {
		$this->bookRepository->createBook($newBook);
	}

	public function getBook(BookId $id): Book {
		$book = $this->bookRepository->findBookById($id);

		if ($book === null) {
			throw BookNotFound::create();
		}

		return $book;
	}
}
