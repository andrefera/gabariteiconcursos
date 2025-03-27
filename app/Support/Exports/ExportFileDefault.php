<?php

namespace App\Support\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

readonly class ExportFileDefault implements FromCollection, WithHeadings
{
    public function __construct(
        private array      $canal,
        private Collection $collection
    )
    {
    }

    public function headings(): array
    {
        return $this->canal;
    }


    public function collection(): Collection
    {
        return $this->collection;
    }
}
