<?php

declare(strict_types = 1);

namespace App\UI\Home;

use Nette\Application\UI\Presenter;

class HomePresenter extends Presenter {
	public function renderDefault(): void {
		$this->template->anyVariable = 'Hello, world!';
	}
}
