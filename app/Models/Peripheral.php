<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peripheral extends Model{

    use HasFactory;

    protected $fillable = [
        'Monitor',
        'Keyboard',
        'Mouse',
        'Printer',
        'UPS',
        'cashBox',
        'Barcode',
        'device_id',
    ];

    public function device(){
        return $this->belongsTo(Device::class);
    }

    public static function search($keyword)
    {
        $searsh = Peripheral::where('Printer', 'LIKE', '%'.$keyword.'%')
            ->get();
    
        if (count($searsh) < 1) {
            return collect([]);
        }
        return $searsh;
    }

}
