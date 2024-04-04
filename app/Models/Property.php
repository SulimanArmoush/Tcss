<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model{

    use HasFactory;

    protected $fillable = [
        'CPU',
        'Motherboard',
        'RAM',
        'Hard',
        'Graphics',
        'powerSupply',
        'OS',
        'NIC',
        'device_id',
    ];

    public function device(){
        return $this->belongsTo(Device::class);
    }

    public static function search($keyword)
    {
        $searsh = Property::where('CPU', 'LIKE', '%'.$keyword.'%')
        ->orWhere('Hard', 'LIKE', '%'.$keyword.'%')
            ->get();
    
        if (count($searsh) < 1) {
            return collect([]);
        }
        return $searsh;
    }

}
