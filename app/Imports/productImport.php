<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Notifications\stepsNotification;
use Maatwebsite\Excel\Events\ImportFailed;


class productImport implements ToModel, WithHeadingRow, WithEvents
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    public User $importedBy;

    public function __construct(User $importedBy)
    {
        $this->importedBy = $importedBy;
    }

    public function headings()
    {
        return [
            'product_code',
            'name',
            'short_description',
            'model',
            'type',
            'make',
            'version',
        ];
    }
    public function model(array $row)
    {
        return new Product([
            'product_code'      => $row['product_code'],
            'name'              => $row['name'],
            'short_description' => $row['short_description'],
            'model'             => $row['model'],
            'type'              => $row['type'],
            'make'              => $row['make'],
            'version'           => $row['version'],
        ]);
    }

    public function chunkSize(): int
    {
        return 100;
    }

    public function registerEvents(): array
    {
        $message = [
            'from' => "From: ".$this->importedBy->email,
            'title' => 'Title: Product Import Failed',
            'greeting' => "For attention: ".$this->importedBy->name,
            'content' => 'Attempt to import Product has failed',
            'datetime' => "Timestamp: ".date('d-m-Y H:i'),
        ];

        $e = function(ImportFailed $event, $message) {
            $this->importedBy->notify(new stepsNotification($message));
        };

        return [ImportFailed::class => $e,];
    }    
}
