<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CustomSelect extends Component
{

    public string $name;
    public string $id;

    public function __construct(string $name, string $id)
    {
        $this->name = $name;
        $this->id = $id;
    }

    public function render()
    {
        return view('components.custom-select');
    }
}
