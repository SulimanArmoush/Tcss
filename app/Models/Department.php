<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model{

    use HasFactory;

    protected $fillable = [
        'name',
        'floor_id',
        'Note',
    ];

    public function device(){
        return $this->hasMany(Device::class);
    }

    public function floor() {
        return $this->belongsTo(Floor::class);
    }

    public function installationServices(){
        return $this->hasMany(InstallationService::class);
    }

    public function maintenanceServices(){
        return $this->hasMany(MaintenanceService::class);
    }

    public static function search($keyword)
    {
        $searsh = Department::where('name', 'LIKE', '%'.$keyword.'%')
            ->get();
    
        if (count($searsh) < 1) {
            return collect([]);
        }
        return $searsh;
    }
    
}
