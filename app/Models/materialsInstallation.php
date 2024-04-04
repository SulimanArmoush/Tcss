<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class materialsInstallation extends Model{

    use HasFactory;

    protected $fillable = [
        'material_id',
        'installation_Service_id',
        'quantity',
    ];

}
