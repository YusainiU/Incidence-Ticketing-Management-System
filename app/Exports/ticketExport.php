<?php

namespace App\Exports;

use App\Models\ticket;
use DateTimeImmutable;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Customer;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;


class ticketExport implements FromCollection, WithHeadings, ShouldAutoSize, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */

    public $customer;
    public $header=[];
    public $ticketCollection;
    
    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
        $this->buildHeader();
        $this->getTickets();
    }

    public function getTickets()
    {
        $this->ticketCollection = ticket::select($this->header)
            ->where('customer_id', '=', $this->customer->id)
            ->get();
    }

    public function buildHeader()
    {
        $this->header = [
            'created_at',
            'ticket_number',
            'customer_reference',
            'category',
            'created_by',
            'source',
            'short_description',
            'description',
            'state',
            'raised_by_user',
            'raised_by_nonuser',
            'contact_telephone',
            'contact_email',
            'assigned_to',
        ];
    }

    public function map($row): array
    {

        $d = new DateTimeImmutable($row->created_at);    
        return [
            $d->format('d/m/Y H:i'),
            $row->ticket_number,
            $row->customer_reference,
            $row->category,
            $row->created_by,
            $row->source,
            $row->short_description,
            $row->description,
            $row->state,
            $row->raised_by_user,
            $row->raised_by_nonuser,
            $row->contact_telephone,
            $row->contact_email,
            $row->assigned_to,
        ];
    }
    public function headings(): array
    {
        return $this->header;
    }

    public function collection()
    {
        return $this->ticketCollection;
        
    }
}
