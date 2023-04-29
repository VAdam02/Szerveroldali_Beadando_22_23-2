<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class GuestLayout extends Component
{
    public $activeGames;

    /**
     * Get the view / contents that represents the component.
     */
    public function __construct($activeGames)
    {
        $this->activeGames = $activeGames;
    }
    
    public function render(): View
    {
        return view('layouts.guest');
    }
}
