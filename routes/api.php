<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\FloorController;
use App\Http\Controllers\HardwarekeyController;
use App\Http\Controllers\InstallationServiceController;
use App\Http\Controllers\MaintenanceServiceController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\PeripheralController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::controller(AuthController::class)->group(function () {
    Route::Post('login', 'login')->name('login');
    Route::Post('logout', 'logout')->middleware(['auth:api'])->name('logout');
});

Route::middleware(['auth:api'])->group(function () {

Route::controller(UserController::class)->group(function () {
    Route::Post('createUser', 'createUser')->name('createUser');
    Route::Delete('deleteUser/{id}', 'deleteUser')->name('deleteUser');
    Route::Put('editUser/{id}', 'editUser')->name('editUser');
    Route::Get('showUsers', 'showUsers')->name('showUsers');
    Route::Get('getUser/{Id}', 'getUser')->name('getUser');
});
Route::controller(DepartmentController::class)->group(function () {
    Route::Post('createDepartment/{floorId}', 'createDepartment')->name('createDepartment');
    Route::Put('editDepartment/{id}', 'editDepartment')->name('editDepartment');
    Route::Delete('deleteDepartment/{id}', 'deleteDepartment')->name('deleteDepartment');
    Route::Get('showDepartments', 'showDepartments')->name('showDepartments');
    Route::Get('departmentsInFloor/{floorId}', 'departmentsInFloor')->name('departmentsInFloor');
    Route::Get('getDepartment/{departmentId}', 'getDepartment')->name('getDepartment');
});
Route::controller(FloorController::class)->group(function () {
    Route::Get('showFloors', 'showFloors')->name('showFloors');
    Route::Get('getFloor/{floorId}', 'getFloor')->name('getFloor');
});
Route::controller(DeviceController::class)->group(function () {
    Route::Post('createDevice/{departmentID}', 'createDevice')->name('createDevice');
    Route::Get('showDevices', 'showDevices')->name('showDevices');
    Route::Get('devicesInDepartment/{departmentId}', 'devicesInDepartment')->name('devicesInDepartment');
    Route::Get('getDevice/{deviceId}', 'getDevice')->name('getDevice');
    Route::Delete('deleteDevice/{id}', 'deleteDevice')->name('deleteDevice');
    Route::Put('editDevice/{id}', 'editDevice')->name('editDevice');
});
Route::controller(HardwarekeyController::class)->group(function () {
    Route::Post('createHardwarekey/{deviceID}', 'createHardwarekey')->name('createHardwarekey');
    Route::Get('showHardwarekeys', 'showHardwarekeys')->name('showHardwarekeys');
    Route::Get('getHardwarekey/{hardwarekeyId}', 'getHardwarekey')->name('getHardwarekey');
    Route::Delete('deleteHardwarekey/{id}', 'deleteHardwarekey')->name('deleteHardwarekey');
    Route::Put('editHardwarekey/{id}', 'editHardwarekey')->name('editHardwarekey');
});
Route::controller(PropertyController::class)->group(function () {
    Route::Post('createProperty/{deviceID}', 'createProperty')->name('createProperty');
    Route::Get('showProperties/{deviceID}', 'showProperties')->name('showProperties');
    Route::Delete('deleteProperty/{id}', 'deleteProperty')->name('deleteProperty');
    Route::Put('editProperties/{id}', 'editProperties')->name('editProperties');
});
Route::controller(PeripheralController::class)->group(function () {
    Route::Post('createPeripheral/{deviceID}', 'createPeripheral')->name('createPeripheral');
    Route::Get('showPeripherals/{deviceID}', 'showPeripherals')->name('showPeripherals');
    Route::Put('editPeripherals/{id}', 'editPeripherals')->name('editPeripherals');
    Route::Delete('deletePeripheral/{id}', 'deletePeripheral')->name('deletePeripheral');
});
Route::controller(MaterialController::class)->group(function () {
    Route::Post('createMaterial', 'createMaterial')->name('createMaterial');
    Route::Get('showMaterial', 'showMaterial')->name('showMaterial');
    Route::Get('getMaterial/{materialId}', 'getMaterial')->name('getMaterial');
    Route::Put('editMaterial/{id}', 'editMaterial')->name('editMaterial');
    Route::Delete('deleteMaterial/{id}', 'deleteMaterial')->name('deleteMaterial');
});
Route::controller(MaintenanceServiceController::class)->group(function () {
    Route::Post('createMaintenanceService/{deviceId}', 'createMaintenanceService')->name('createMaintenanceService');
    Route::Get('showMaintenanceService', 'showMaintenanceService')->name('showMaintenanceService');
    Route::Delete('deleteMaintenanceService/{id}', 'deleteMaintenanceService')->name('deleteMaintenanceService');
    Route::Get('getMaintenanceService/{id}', 'getMaintenanceService')->name('getMaintenanceService');
});
Route::controller(InstallationServiceController::class)->group(function () {
    Route::Post('createInstallationService/{deviceId}', 'createInstallationService')->name('createInstallationService');
    Route::Get('showInstallationService', 'showInstallationService')->name('showInstallationService');
    Route::Get('getInstallationService/{id}', 'getInstallationService')->name('getInstallationService');
    Route::Delete('deleteInstallationService/{id}', 'deleteInstallationService')->name('deleteInstallationService');
});
Route::controller(ReportController::class)->group(function () {
    Route::Get('exportMaintenanceService', 'exportMaintenanceService')->name('exportMaintenanceService');
    Route::Get('exportMaintenanceOfUser', 'exportMaintenanceOfUser')->name('exportMaintenanceOfUser');
    Route::Get('exportMaintenanceOfDepartment', 'exportMaintenanceOfDepartment')->name('exportMaintenanceOfDepartment');
    Route::Get('exportInstallationService', 'exportInstallationService')->name('exportInstallationService');
    Route::Get('exportInstallationOfUser', 'exportInstallationOfUser')->name('exportInstallationOfUser');
    Route::Get('exportInstallationOfDepartment', 'exportInstallationOfDepartment')->name('exportInstallationOfDepartment');
    Route::Get('MaterialReport', 'MaterialReport')->name('MaterialReport');
    Route::Get('HardeareKeyReport', 'HardeareKeyReport')->name('HardeareKeyReport');
    Route::Get('DeviceReport', 'DeviceReport')->name('DeviceReport');
    Route::Get('ComputersReport', 'ComputersReport')->name('ComputersReport');
    Route::Get('search', 'search')->name('search');
});
});

