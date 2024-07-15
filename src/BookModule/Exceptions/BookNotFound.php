<?php

declare(strict_types = 1);

namespace App\BookModule\Exceptions;

use Throwable;

class BookNotFound extends BookCreateException {
	public static function create(?string $message = null, ?Throwable $previous = null): self {
		$message ??= 'Book not found.';
		return new self($message, 404, $previous);
	}
}
