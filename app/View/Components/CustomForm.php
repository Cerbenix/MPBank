<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CustomForm extends Component
{
    public string $method;
    public string $action;

    public function __construct(string $method, string $action)
    {
        $this->method = $method;
        $this->action = $action;
    }


    public function render()
    {
        return view('components.custom-form');
    }
}
