<?php

declare(strict_types = 1);

namespace App\BookModule\Repository;

use App\BookModule\Dto\CreateBookDto;
use App\BookModule\Dto\UpdateBookDto;
use App\BookModule\Entity\Book;
use App\BookModule\ValueObject\Author;
use App\BookModule\ValueObject\BookId;
use App\BookModule\ValueObject\Title;

interface BookRepository {
	public function create(CreateBookDto $newBookDto): Book;

	public function delete(BookId $id): void;

	public function findBookById(BookId $id): ?Book;

	public function findBookByTitle(Title $title): ?Book;

	/**
	 * @return array<Book>
	 */
	public function findBooksByAuthor(Author $author): array;

	/**
	 * @return array<Book>
	 */
	public function getAll(): array;

	public function update(BookId $id, UpdateBookDto $updateBookDto): Book;
}
