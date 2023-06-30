<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ActionButton extends Component
{

    public string $href;

    public function __construct(string $href)
    {
        $this->href = $href;
    }

    public function render()
    {
        return view('components.action-button');
    }
}
