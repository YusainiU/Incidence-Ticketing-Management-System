<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    /** @use HasFactory<\Database\Factories\AssetFactory> */
    use HasFactory;

    protected $fillable = [
        'short_description',
        'asset_number',
        'product_id',
        'supplier_id',
        'customer_id',
        'active',
        'buy_price',
        'sell_price',
        'notes',
        'license_number',
        'location',
        'technical_specifications',
        'mac_address',
        'ip_address',
    ];

    public function setAssetNumberAttribute($value)
    {
        $bytes = random_bytes(5);
        $r = strtoupper(bin2hex($bytes));
        $prefix = Config()->get('steps.prefix_asset');
        $this->attributes['asset_number'] = $prefix . $r;
        /*
            To trigger the mutator, when creating an asset
            set the asset_number to null .. example 
            
            ...
            $asset->asset_number = null; 
            $asset->save();

            This will auto create the asset_number  
        */
    }

    public static function getProduct(int $product_id)
    {
        return Product::where('id','=',$product_id)->get()->first();
    }

    public static function getSupplier(int $supplier_id)
    {
        return Supplier::where('id','=',$supplier_id)->get()->first();
    }

    public static function getCustomer(int $customer_id)
    {       
        return Customer::where('id','=',$customer_id)->get()->first();
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public static function listAssets(array $arrayOfIds)
    {
        return Asset::whereIn('id',$arrayOfIds)->get();
    }
        
}
