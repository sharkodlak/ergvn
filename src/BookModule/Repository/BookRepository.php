<?php

declare(strict_types = 1);

namespace App\BookModule\Repository;

use App\BookModule\Dto\CreateBookDto;
use App\BookModule\Entity\Book;
use App\BookModule\ValueObject\Author;
use App\BookModule\ValueObject\BookId;
use App\BookModule\ValueObject\Title;

interface BookRepository {
	public function createBook(CreateBookDto $newBook): void;

	public function findBookById(BookId $id): ?Book;

	public function findBookByTitle(Title $title): ?Book;

	/**
	 * @return array<Book>
	 */
	public function findBooksByAuthor(Author $author): array;
}
