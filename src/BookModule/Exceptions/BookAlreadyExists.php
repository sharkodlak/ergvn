<?php

declare(strict_types = 1);

namespace App\BookModule\Exceptions;

use Throwable;

class BookAlreadyExists extends BookCreateException {
	public static function create(?string $message = null, ?Throwable $previous = null): self {
		$message ??= 'Book already exists.';
		return new self($message, 409, $previous);
	}
}
