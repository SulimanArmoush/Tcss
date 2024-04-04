<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model{
    
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'quantity',
        'price',
    ];

    public function installationServices(){
    return $this->belongsToMany(InstallationService::class, 'materials_installations');
    }

    public static function search($keyword)
    {
        $searsh = Material::where('name', 'LIKE', '%'.$keyword.'%')
        ->orWhere('code', 'LIKE', '%'.$keyword.'%')
            ->get();
    
        if (count($searsh) < 1) {
            return collect([]);
        }
        return $searsh;
    }

}
