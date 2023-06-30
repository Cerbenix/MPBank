<?php

namespace App\View\Components;

use Illuminate\View\Component;

class DeleteButton extends Component
{
    public string $href;
    public string $accountId;

    public function __construct($href, $accountId)
    {
        $this->href = $href;
        $this->accountId = $accountId;
    }

    public function render()
    {
        return view('components.delete-button');
    }
}
