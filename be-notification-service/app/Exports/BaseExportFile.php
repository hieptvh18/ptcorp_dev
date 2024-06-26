<?php

namespace App\Exports;

use Illuminate\Database\Eloquent\Collection;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Jobs\Middleware\RateLimited;

class BaseExportFile implements FromCollection, ShouldAutoSize, WithHeadings
{
    use RegistersEventListeners;

    /**
     * @return \Illuminate\Support\Collection
     */

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function middleware()
    {
        return [new RateLimited];
    }

    public function headings(): array
    {
        return [];
    }

    public function collection()
    {
        return $this->data;
    }
}
