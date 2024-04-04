<?php
namespace App\Http\Controllers;
use App\Models\InstallationService;
use App\Models\MaintenanceService;
use App\Models\Material;
use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class InstallationServiceController extends Controller {

    public function createInstallationService(Request $request,$deviceId) {

        $foreignId = Device::find($deviceId);
        if (!$foreignId) {return response()->json(['message' => 'Invalid foreignId'], 400);}

        $validator = validator::make($request->all(), [
            'description' => ['string', 'max:255', 'min:2'],
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->all(), status: 400);
        }

        $validatedData = $this->validate($request, [
            'materials' => 'required|array|min:1',
            'materials.*.material_id' => 'required|exists:materials,id',
            'materials.*.quantity' => 'required|min:1|integer',
        ]);

        $materialIds = [];
        $materialInfo = [];
                foreach ($request->materials as $material) {
            $materialIds[] = $material['material_id'];
            $materialInfo[$material['material_id']] = Material::find($material['material_id']);
        }

        $serviceInfo = InstallationService::create([
            'department_id' => $foreignId->department_id,
            'device_id' => $deviceId,
            'user_id' => Auth::id(),
            'description' => $request->description,
        ]);

        MaintenanceService::create([
            'department_id' => $foreignId->department_id,
            'device_id' => $deviceId,
            'user_id' => Auth::id(),
            'description' => $request->description,
        ]);

        foreach ($validatedData['materials'] as $material) {
            $mat = $materialInfo[$material['material_id']];
            $serviceInfo->materials()->attach($material['material_id'], [
                'quantity' => $material['quantity'],
            ]);
            $mat->decrement('quantity', $material['quantity']);
        }


        return response()->json(['message' => 'Installation Service created successfully'], 200);
    }

    public function showInstallationService(){

        $installationService = InstallationService::
        With( 'device:id,name','department:id,name','user:id,name' ,'materials:name')
        ->get();

        if ($installationService->isEmpty())
         {
            return response()->json(['message' => 'no Installation Service added'], 404);
         }

        return response()->json($installationService, 200);
    }

    public function getInstallationService($id){

        $installationService = InstallationService::Where('id',$id)
        ->with( 'device:id,name','department:id,name','user:id,name' ,'materials:name')
        ->get();

        if ($installationService->isEmpty())
         {
            return response()->json(['message' => 'no Installation Service added'], 404);
         }

        return response()->json($installationService, 200);
    }

    public function deleteInstallationService($id){

        $installationService = InstallationService::find($id);
        if (! $installationService) {
            return response()->json(['message' => 'Installation  Service not found'], 404);
        }
        if (Auth::id() != $installationService->user_id && auth()->user()->role_id != 1) {
            return response()->json(['message' => 'Access Denied'], 404);
        } 

        foreach ($installationService->materials as $material) {
            $mat = Material::find($material->pivot->material_id);
            $mat->increment('quantity', $material->pivot->quantity);
        }
        
        $installationService->delete();
        return response()->json(['message' => 'Installation  Service Deleted successfully'], 200);
    }
}
