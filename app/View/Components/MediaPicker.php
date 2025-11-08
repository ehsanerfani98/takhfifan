<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MediaPicker extends Component
{
    public string $name;
    public string $id;
    public ?string $value;
    public bool $multiple;
    public bool $preview;

    /**
     * Create a new component instance.
     */
    public function __construct(
        string $name,
        string $id = null,
        string $value = null,
        bool $multiple = false,
        bool $preview = true
    ) {
        $this->name = $name;
        $this->id = $id ?? $name;
        $this->value = $value;
        $this->multiple = $multiple;
        $this->preview = $preview;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.media-picker');
    }
}