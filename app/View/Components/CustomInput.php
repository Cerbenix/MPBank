<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CustomInput extends Component
{

    public string $type;
    public string $name;
    public ?string $value;
    public ?string $id;
    public ?string $placeholder;

    public function __construct(
        string $type,
        string $name,
        string $id = null,
        string $value = null,
        string $placeholder = null
    )
    {
        $this->type = $type;
        $this->name = $name;
        $this->value = $value;
        $this->id = $id;
        $this->placeholder = $placeholder;
    }


    public function render()
    {
        return view('components.custom-input');
    }
}
