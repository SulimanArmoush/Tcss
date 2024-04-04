<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceService extends Model{

    use HasFactory;

    protected $fillable = [
        'department_id',
        'device_id',
        'user_id',
        'description',
    ];

    public function department(){
        return $this->belongsTo(Department::class);
    }

    public function device(){
        return $this->belongsTo(Device::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
