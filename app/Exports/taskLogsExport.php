<?php

namespace App\Exports;

use App\Models\taskLogs;
use App\Models\ticket;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;

class taskLogsExport implements FromCollection, WithHeadings, ShouldAutoSize, WithColumnFormatting, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */

    public ticket $ticket;
    public $header = [];
    public $logCollection;

    public function __construct(ticket $ticket)
    {
        $this->ticket = $ticket;
        $this->buildHeader();
        $this->getTaskLogs();
    }

    public function getTaskLogs()
    {

        $this->logCollection = taskLogs::select($this->header)
            ->where('ticket_id', '=', $this->ticket->id)
            ->get();

    }

    public function map($log): array
    {
        return [
            $log->number,
            Date::dateTimeToExcel($log->created_at),
            $log->name,
            $log->short_description,
            $log->type,
            $log->source,
            $log->user_id,
            $log->external_user,
            $log->sla_tasks_id,
            $log->description,
            $log->notification_sent_at ? Date::dateTimeToExcel(date_create($log->notification_sent_at)) : null,
            $log->require_attention,
            $log->task_site_visit_id,
        ];
    }

    public function columnFormats(): array
    {
        return [
          'B' => NumberFormat::FORMAT_DATE_DATETIME,
          'K' => NumberFormat::FORMAT_DATE_DATETIME,
        ];
    }



    public function buildHeader()
    {
        $this->header = [
            "number",
            "created_at",
            "name",
            "short_description",
            "type",
            "source",
            "user_id",
            "external_user",
            "sla_tasks_id",
            "description",
            "notification_sent_at",
            "require_attention",
            "task_site_visit_id",
        ];
    }

    public function headings(): array
    {
        return $this->header;
    }    
    public function collection()
    {
        return $this->logCollection;
    }
}
