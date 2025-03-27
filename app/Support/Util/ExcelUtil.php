<?php

namespace App\Support\Util;

use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ExcelUtil
{

    public static function export($class, string $filename, string $type): BinaryFileResponse
    {
        if (!in_array($type, ['xls', 'csv'])) {
            $type = 'csv';
        }

        $fn = $filename . '-' . date('Y-m-d_H-i-s');

        return Excel::download($class, $fn . '.' . $type);
    }

    public static function import($class, $filepath): array
    {
        return Excel::toArray($class, $filepath);
    }
}