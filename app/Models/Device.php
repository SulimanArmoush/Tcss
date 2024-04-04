<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model{

    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'department_id',
        'type',
        'Note',
    ];

    public function department(){
        return $this->belongsTo(Department::class);
    }

    public function property(){
        return $this->hasOne(Property::class);
    }

    public function peripheral() {
        return $this->hasOne(Peripheral::class);
    }

    public function hardwarekey(){
        return $this->hasOne(Hardwarekey::class);
    }

    public function installationServices(){
        return $this->hasMany(InstallationService::class);
    }

    public function maintenanceServices(){
        return $this->hasMany(MaintenanceService::class);
    }

    public static function search($keyword)
    {
        $searsh = Device::where('name', 'LIKE', '%'.$keyword.'%')
        ->orWhere('type', 'LIKE', '%'.$keyword.'%')
            ->get();
    
        if (count($searsh) < 1) {
            return collect([]);
        }
        return $searsh;
    }

}
