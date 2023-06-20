<?php

namespace App\View\Components;

use Illuminate\View\Component;

class modal extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(public string $id, public $forms, public $btnsv, public $title, public $size)
    {
        //
        $this->forms = json_decode(htmlspecialchars_decode($forms));
        // $this->forms = ($forms);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.modal');
    }
}
