<?php

namespace App\Imports;

use App\Models\Asset;
use App\Models\Customer;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Events\ImportFailed;
use App\Notifications\stepsNotification;

class assetImport implements ToModel, WithHeadingRow, WithEvents
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    public Customer $customer;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    public function headings()
    {
        return [
            'short_description',
            'asset_number',
            'product_id',
            'supplier_id',
            'buy_price',
            'sell_price',
            'notes',
            'license_number',
            'location',
            'technical_specifications',
            'mac_address',
            'ip_address',
        ];
    }

    public function model(array $row)
    {

        if(!$row['short_description'])
        {
            return [];
        }

        return new Asset([
            'short_description' => $row['short_description'],
            'asset_number' => $row['asset_number'],
            'product_id' => $row['product_id'],
            'supplier_id' => $row['supplier_id'],
            'buy_price' => $row['buy_price'],
            'sell_price' => $row['sell_price'],
            'notes' => $row['notes'],
            'license_number' => $row['license_number'],
            'location' => $row['location'],
            'technical_specifications' => $row['technical_specification'],
            'mac_address' => $row['mac_address'],
            'ip_address' => $row['ip_address'],
            'customer_id' => $this->customer->id,
            'active' => 1,
        ]);
    }

    public function registerEvents(): array
    {

        $e = function (ImportFailed $event) {
            $message = [
                'from' => "From: " . Auth()->user()->email,
                'title' => 'Title: Product Import Failed',
                'greeting' => "For attention: " . Auth()->user()->name,
                'content' => 'Attempt to import Assets for Customer ' . $this->customer->name . ' has failed',
                'datetime' => "Timestamp: " . date('d-m-Y H:i'),
            ];
            Auth()->user()->notify(new stepsNotification($message));
        };

        return [ImportFailed::class => $e,];
    }

}
