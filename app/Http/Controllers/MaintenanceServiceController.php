<?php
namespace App\Http\Controllers;
use App\Models\Device;
use App\Models\MaintenanceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class MaintenanceServiceController extends Controller{

    public function createMaintenanceService(Request $request,$deviceId) {

        $foreignId = Device::find($deviceId);
        if (!$foreignId) {return response()->json(['message' => 'Invalid foreignId'], 400);}

        $validator = validator::make($request->all(), [
            'description' => ['string', 'max:255', 'min:2'],
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->all(), status: 400);
        }

        MaintenanceService::create([
            'department_id' => $foreignId->department_id,
            'device_id' => $deviceId,
            'user_id' => Auth::id(),
            'description' => $request->description,
        ]);

        return response()->json(['message' => 'Maintenance Service created successfully'], 200);
    }

    public function showMaintenanceService(){

        $maintenanceService = MaintenanceService::
        With( 'device:id,name','department:id,name','user:id,name')
        ->get();

        if ($maintenanceService->isEmpty())
         {
            return response()->json(['message' => 'no MaintenanceService added'], 404);
         }

        return response()->json($maintenanceService, 200);
    }

    public function getMaintenanceService($id) {

        $maintenanceService = MaintenanceService::Where('id',$id)
        ->With( 'device:id,name','department:id,name','user:id,name')
        ->get();

        if ($maintenanceService->isEmpty())
         {
            return response()->json(['message' => 'no MaintenanceService added'], 404);
         }

        return response()->json($maintenanceService, 200);
    }

    public function deleteMaintenanceService($id){

        $maintenanceService = MaintenanceService::find($id);

        if (! $maintenanceService) {
            return response()->json(['message' => 'Maintenance Service not found'], 404);
        } 

        if (Auth::id() != $maintenanceService->user_id && auth()->user()->role_id != 1) {
            return response()->json(['message' => 'Access Denied'], 404);
        }

        //$maintenanceService->delete();
        return response()->json(['message' => 'Maintenance Service Deleted successfully'], 200);
    }
}
