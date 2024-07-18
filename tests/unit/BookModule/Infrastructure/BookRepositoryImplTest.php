<?php

declare(strict_types = 1);

namespace Tests\Unit\BookModule\Infrastructure;

use App\BookModule\Dto\CreateBookDto;
use App\BookModule\Dto\UpdateBookDto;
use App\BookModule\Infrastructure\BookRepositoryImpl;
use App\BookModule\ValueObject\BookId;
use PDO;
use PDOStatement;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class BookRepositoryImplTest extends TestCase {
	private const BOOK_ROW = [
		'book_id' => 'book-007',
		'author' => 'Ian Fleming',
		'title' => 'Goldfinger',
		'genre' => 'Spy fiction',
		'description' => 'Goldfinger is a British spy film and the third installment
			in the James Bond series produced by Eon Productions.',
		'price' => 9.99,
		'publish_date' => '1959-03-23',
	];

	private PDO&MockObject $pdo;

	private PDOStatement&MockObject $stmt;

	private BookRepositoryImpl $bookRepository;

	public function setUp(): void {
		parent::setUp();

		$this->pdo = $this->createMock(PDO::class);
		$this->stmt = $this->createMock(PDOStatement::class);
		$this->bookRepository = new BookRepositoryImpl($this->pdo);
	}

	public function testCreate(): void {
		$bookRow = self::BOOK_ROW;
		$bookId = new BookId($bookRow['book_id']);
		$this->pdo->expects(self::exactly(2))
			->method('prepare')
			->willReturn($this->stmt);
		$this->stmt->expects(self::exactly(2))
			->method('execute')
			->willReturn(true);
		$this->stmt->expects(self::once())
			->method('fetch')
			->willReturnOnConsecutiveCalls(false);
		$this->stmt->expects(self::once())
			->method('rowCount')
			->willReturn(1);
		$newBookDto = new CreateBookDto(...\array_values($bookRow));
		$book = $this->bookRepository->create($newBookDto);
		self::assertSame($book->getId()->getValue(), $bookId->getValue());
		self::assertSame($book->getAuthor()->getValue(), $bookRow['author']);
	}

	public function testCreateBookExists(): void {
		$bookRow = self::BOOK_ROW;
		$bookId = new BookId($bookRow['book_id']);
		$this->pdo->expects(self::once())
			->method('prepare')
			->willReturn($this->stmt);
		$this->stmt->expects(self::once())
			->method('execute')
			->with(['id' => $bookId->getValue()])
			->willReturn(true);
		$this->stmt->expects(self::once())
			->method('fetch')
			->willReturn($bookRow);
		$this->expectExceptionMessage('Book already exists');
		$newBookDto = new CreateBookDto(...\array_values($bookRow));
		$this->bookRepository->create($newBookDto);
	}

	public function testDelete(): void {
		$bookId = new BookId(self::BOOK_ROW['book_id']);
		$this->pdo->expects(self::once())
			->method('prepare')
			->willReturn($this->stmt);
		$this->stmt->expects(self::once())
			->method('execute')
			->with(['id' => $bookId->getValue()])
			->willReturn(true);
		$this->bookRepository->delete($bookId);
	}

	public function testFind(): void {
		$bookRow = self::BOOK_ROW;
		$bookId = new BookId($bookRow['book_id']);
		$this->pdo->expects(self::once())
			->method('prepare')
			->willReturn($this->stmt);
		$this->stmt->expects(self::once())
			->method('execute')
			->with(['id' => $bookId->getValue()])
			->willReturn(true);
		$this->stmt->expects(self::once())
			->method('fetch')
			->willReturn($bookRow);
		$book = $this->bookRepository->find($bookId);
		self::assertSame($book?->getId()->getValue(), $bookId->getValue());
		self::assertSame($book?->getAuthor()->getValue(), $bookRow['author']);
	}

	public function testFindAll(): void {
		$this->markTestIncomplete('This test has not been implemented yet.');
	}

	public function testListByAuthor(): void {
		$this->markTestIncomplete('This test has not been implemented yet.');
	}

	public function testUpdate(): void {
		$bookRow = self::BOOK_ROW;
		$bookId = new BookId($bookRow['book_id']);
		unset($bookRow['book_id']);
		$this->pdo->expects(self::once())
			->method('prepare')
			->willReturn($this->stmt);
		$this->stmt->expects(self::once())
			->method('execute')
			->willReturn(true);
		$updateBookDto = new UpdateBookDto(...\array_values($bookRow));
		$book = $this->bookRepository->update($bookId, $updateBookDto);
		self::assertSame($book->getId()->getValue(), $bookId->getValue());
		self::assertSame($book->getAuthor()->getValue(), $bookRow['author']);
	}
}
