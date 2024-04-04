<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DeviceController extends Controller
{
    public function createDevice(Request $request, $departmentID)
    {

        $foreignId = Department::find($departmentID);
        if (! $foreignId) {
            return response()->json(['message' => 'Invalid foreignId'], 400);
        }

        $validator = validator::make($request->all(), [
            'name' => ['string', 'unique:devices,name', 'max:15', 'min:2'],
            'type' => ['string', 'max:15', 'min:2'],
            'description' => ['string', 'max:255', 'min:2'],
            'Note' => ['string', 'max:255', 'min:2'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->all(), status: 400);
        }

        Device::create([
            'name' => $request->name,
            'type' => $request->type,
            'description' => $request->description,
            'Note' => $request->Note,
            'department_id' => $departmentID,
        ]);

        return response()->json(['message' => 'Device created successfully'], 200);
    }

    public function showDevices()
    {

        $devices = Device::with('department:id,name')->get();

        if ($devices->isEmpty()) {
            return response()->json(['message' => 'no Device added'], 404);
        }

        return response()->json($devices, 200);
    }

    public function devicesInDepartment($departmentId)
    {

        $devices = Device::Where('department_id', $departmentId)->With('department:id,name')->get();

        if ($devices->isEmpty()) {
            return response()->json(['message' => 'no Device added'], 404);
        }

        return response()->json($devices, 200);
    }

    public function getDevice($deviceId)
    {

        $device = Device::Where('id', $deviceId)
            ->With('department:id,name')->get();

        if ($device->isEmpty()) {
            return response()->json(['message' => 'no Device added'], 404);
        }

        return response()->json($device, 200);
    }

    public function editDevice(Request $request, $id)
    {

        $validator = validator::make($request->all(), [
            'name' => ['sometimes', 'string', 'max:15', 'min:2'],
            'type' => ['sometimes', 'string', 'max:15', 'min:2'],
            'description' => ['sometimes', 'string', 'max:255', 'min:2'],
            'Note' => ['sometimes', 'string', 'max:255', 'min:2'],
            'updated_at' => now(),
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->all(), status: 400);
        }

        $device = Device::find($id);
        if (! $device) {
            return response()->json(['message' => 'Device not found'], 404);
        }

        $device->update($request->all());

        return response()->json(['message' => 'Device Updated successfully'], 200);
    }

    public function deleteDevice($id)
    {

        $device = Device::find($id);
        if (! $device) {
            return response()->json(['message' => 'Device not found'], 404);
        }

        $device->delete();

        return response()->json(['message' => 'Device Deleted successfully'], 200);
    }
    
}
