<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;

class View
{
    protected $html;

    public function __construct($html)
    {
        $this->html = $html;
    }

    public function render()
    {
        return $this->html;
    }
}

class ReportExport implements FromView
{
    protected $html;

    public function __construct($html)
    {
        $this->html = $html;
    }

    public function view()
    {
        return new View($this->html);
    }
}
