<?php

declare(strict_types = 1);

namespace App\BookModule\Exceptions;

use Throwable;

/** phpcs:ignoreFile SlevomatCodingStandard.Classes.SuperfluousExceptionNaming.SuperfluousSuffix */
class BookCreateException extends BookRuntimeException implements Throwable {
	public static function create(?string $message = null, ?Throwable $previous = null): self {
		$message ??= 'Book creation failed.';
		return new self($message, 409, $previous);
	}
}
