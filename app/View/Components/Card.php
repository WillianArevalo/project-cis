<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Card extends Component
{
    public $report;
    public $month;
    public $send;
    /**
     * Create a new component instance.
     */
    public function __construct($report, $month, $send = false)
    {
        $this->report = $report;
        $this->month = $month;
        $this->send = $send;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.card');
    }
}