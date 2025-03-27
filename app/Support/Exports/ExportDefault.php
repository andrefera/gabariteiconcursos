<?php

namespace App\Support\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

readonly class ExportDefault implements FromView
{
    public function __construct(
        private string $view,
        private array  $array

    )
    {
    }

    public function view(): View
    {
        return view($this->view, $this->array);
    }
}
