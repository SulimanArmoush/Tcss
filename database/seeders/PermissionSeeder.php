<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $permission =
        [
            [
                'name' => 'login', //1
            ],
            [
                'name' => 'logout', //2
            ],
            [
                'name' => 'createUser', //3
            ],
            [
                'name' => 'deleteUser', //4
            ],
            [
                'name' => 'editUser', //5
            ],
            [
                'name' => 'showUsers', //6
            ],
            [
                'name' => 'getUser', //7
            ],
            [
                'name' => 'createDepartment', //8
            ],
            [
                'name' => 'editDepartment', //9
            ],
            [
                'name' => 'deleteDepartment', //10
            ],
            [
                'name' => 'showDepartments', //11
            ],
            [
                'name' => 'departmentsInFloor', //12
            ],
            [
                'name' => 'getDepartment', //13
            ],
            [
                'name' => 'showFloors', //14
            ],
            [
                'name' => 'getFloor', //15
            ],
            [
                'name' => 'createDevice', //16
            ],
            [
                'name' => 'showDevices', //17
            ],
            [
                'name' => 'devicesInDepartment', //18
            ],
            [
                'name' => 'getDevice', //19
            ],
            [
                'name' => 'deleteDevice', //20
            ],
            [
                'name' => 'editDevice', //21
            ],
            [
                'name' => 'createHardwarekey', //22
            ],
            [
                'name' => 'showHardwarekeys', //23
            ],
            [
                'name' => 'getHardwarekey', //24
            ],
            [
                'name' => 'deleteHardwarekey', //25
            ],
            [
                'name' => 'editHardwarekey', //26
            ],
            [
                'name' => 'createProperty', //27
            ],
            [
                'name' => 'showProperties', //28
            ],
            [
                'name' => 'deleteProperty', //29
            ],
            [
                'name' => 'editProperties', //30
            ],
            [
                'name' => 'createPeripheral', //31
            ],
            [
                'name' => 'showPeripherals', //32
            ],
            [
                'name' => 'editPeripherals', //33
            ],
            [
                'name' => 'deletePeripheral', //34
            ],
            [
                'name' => 'createMaterial', //35
            ],
            [
                'name' => 'showMaterial', //36
            ],
            [
                'name' => 'getMaterial', //37
            ],
            [
                'name' => 'editMaterial', //38
            ],
            [
                'name' => 'deleteMaterial', //39
            ],
            [
                'name' => 'createMaintenanceService', //40
            ],
            [
                'name' => 'showMaintenanceService', //41
            ],
            [
                'name' => 'deleteMaintenanceService', //42
            ],
            [
                'name' => 'getMaintenanceService', //43
            ],
            [
                'name' => 'createInstallationService', //44
            ],
            [
                'name' => 'showInstallationService', //45
            ],
            [
                'name' => 'getInstallationService', //46
            ],
            [
                'name' => 'deleteInstallationService', //47
            ],
            [
                'name' => 'exportMaintenanceService', //48
            ],
            [
                'name' => 'exportMaintenanceOfUser', //49
            ],
            [
                'name' => 'exportMaintenanceOfDepartment', //50
            ],
            [
                'name' => 'exportInstallationService', //51
            ],
            [
                'name' => 'exportInstallationOfUser', //52
            ],
            [
                'name' => 'exportInstallationOfDepartment', //53
            ],
            [
                'name' => 'MaterialReport', //54
            ],
            [
                'name' => 'HardeareKeyReport', //55
            ],
            [
                'name' => 'DeviceReport', //56
            ],
            [
                'name' => 'ComputersReport', //57
            ],
            [
                'name' => 'search', //58
            ],
        ];
        Permission::insert($permission);
    }
}
