<?php

namespace App\UI\Home;

use Nette\Application\UI\Presenter;

class HomePresenter extends Presenter
{
    public function renderDefault()
    {
        $this->template->anyVariable = 'Hello, world!';
    }
}
