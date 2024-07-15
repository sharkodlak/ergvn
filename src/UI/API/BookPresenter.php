<?php

declare(strict_types = 1);

namespace App\UI\Home;

use App\BookModule\Dto\CreateBookDto;
use App\BookModule\Dto\UpdateBookDto;
use App\BookModule\Service\BookCrudService;
use App\BookModule\ValueObject\BookId;
use Nette\Application\UI\Presenter;
use Nette\Http\IResponse;

class BookPresenter extends Presenter {
	public function __construct(
		private BookCrudService $bookCrudService
	) {
	}

	public function startup(): void {
		parent::startup();

		$method = $this->getHttpRequest()->getMethod();
		$action = $this->getAction();

		// Map methods to actions
		$allowedMethods = [
			'getBooks' => 'GET',
			'createBook' => 'POST',
			'readBook' => 'GET',
			'updateBook' => 'PUT',
			'deleteBook' => 'DELETE',,
		];

		if (!isset($allowedMethods[$action]) || $method === $allowedMethods[$action]) {
			return;
		}

		$this->error('Method Not Allowed', IResponse::S405_MethodNotAllowed);
	}

	public function actionGetBooks(): void {
		$books = $this->bookCrudService->getBooks();
		$this->sendJson($books);
	}

	public function actionCreateBook(): void {
		$data = \json_decode($this->getHttpRequest()->getRawBody(), true, flags: \JSON_THROW_ON_ERROR);
		$newBookDto = new CreateBookDto(
			$data['id'],
			$data['author'],
			$data['title'],
			$data['genre'],
			$data['description'],
			$data['price'],
			$data['publishDate']
		);
		$book = $this->bookCrudService->createBook($newBookDto);
		$this->getHttpResponse()->setCode(IResponse::S201_Created);
		$this->sendJson($book);
	}

	public function actionReadBook(string $id): void {
		$bookId = new BookId($id);
		$book = $this->bookCrudService->getBook($bookId);
		$this->sendJson($book);
	}

	public function actionUpdateBook(string $id): void {
		$bookId = new BookId($id);
		$data = \json_decode($this->getHttpRequest()->getRawBody(), true, flags: \JSON_THROW_ON_ERROR);
		$updateBookDto = new UpdateBookDto(
			$data['author'],
			$data['title'],
			$data['genre'],
			$data['description'],
			$data['price'],
			$data['publishDate']
		);
		$book = $this->bookCrudService->updateBook($bookId, $updateBookDto);
		$this->sendJson($book);
	}

	public function actionDeleteBook(string $id): void {
		$bookId = new BookId($id);
		$this->bookCrudService->deleteBook($bookId);
		$this->getHttpResponse()->setCode(IResponse::S204_NoContent);
	}
}
