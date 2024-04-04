<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hardwarekey extends Model{

    use HasFactory;

    protected $fillable = [
        'type',
        'sereal',
        'exDate',
        'description',
        'device_id',
    ];
  
    public function device(){
        return $this->belongsTo(Device::class);
    }

    public static function search($keyword)
    {
        $searsh = Hardwarekey::where('type', 'LIKE', '%'.$keyword.'%')
        ->orWhere('sereal', 'LIKE', '%'.$keyword.'%')
            ->get();
    
        if (count($searsh) < 1) {
            return collect([]);
        }
        return $searsh;
    }
}
