<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Alert extends Component
{
    /**
     * @var string
     */
    public string $message;

    /**
     * Create a new component instance.
     *
     * @param string $message
     * @return void
     */
    public function __construct(string $message = '')
    {
        $this->message = $message;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View
     */
    public function render(): View
    {
        return view('components.alert');
    }
}
