<?php
namespace App\Http\Controllers;
use App\Models\Hardwarekey;
use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HardwarekeyController extends Controller{

    public function createHardwarekey(Request $request , $deviceId){

        $foreignId = Device::find($deviceId);
        if (!$foreignId) {return response()->json(['message' => 'Invalid foreignId'], 400);}

        $validator = validator::make($request->all(), [
            'type' => ['string', 'max:15', 'min:2'],
            'sereal' => ['string', 'max:15', 'min:2'],
            'exDate' => ['date', 'max:15', 'min:2'],
            'description' => ['string', 'max:255', 'min:2'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->all(), status: 400);
        }

        Hardwarekey::create([
            'type' => $request->type,
            'sereal'=> $request->sereal,
            'exDate'=> $request->exDate,
            'description'=> $request->description,
            'device_id' => $deviceId ,
        ]);

        return response()->json(['message' => 'Hardwarekey created successfully'], 200);
    }

    public function showHardwarekeys(){

        $hardwarekey = Hardwarekey::Get();

        if ($hardwarekey->isEmpty())
         {
            return response()->json(['message' => 'no Hardwarekey added'], 404);
         }

        return response()->json($hardwarekey, 200);
    }

    public function getHardwarekey($hardwarekeyId){

        $hardwarekey = Hardwarekey::Where('id' , $hardwarekeyId)->get();

        if ($hardwarekey->isEmpty())
         {
            return response()->json(['message' => 'no Hardwarekey added'], 404);
         }

        return response()->json($hardwarekey, 200);
    }

    public function editHardwarekey(Request $request , $id){

        $validator = validator::make($request->all(), [
            'type' => ['sometimes','string', 'max:15', 'min:2'],
            'sereal' => ['sometimes','string', 'max:15', 'min:2'],
            'exDate' => ['sometimes','date', 'max:15', 'min:2'],
            'description' => ['sometimes','string', 'max:255', 'min:2'],
            'updated_at' => now(),
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->all(), status: 400);
        }

        $hardwarekey = Hardwarekey::find($id);
        if (! $hardwarekey) {
            return response()->json(['message' => 'Hardwarekey not found'], 404);
        }

        $hardwarekey->update($request->all());

        return response()->json(['message' => 'Hardwarekey Updated successfully'], 200);
    }

    public function deleteHardwarekey($id){

        $hardwarekey = Hardwarekey::find($id);
        if (! $hardwarekey) {
            return response()->json(['message' => 'Hardwarekey not found'], 404);
        }

        $hardwarekey->delete();
        return response()->json(['message' => 'Hardwarekey Deleted successfully'], 200);
    }
}
