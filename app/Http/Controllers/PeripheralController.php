<?php
namespace App\Http\Controllers;
use App\Models\Peripheral;
use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PeripheralController extends Controller{

    public function createPeripheral(Request $request , $deviceId){

        $foreignId = Device::find($deviceId);
        if (!$foreignId) {return response()->json(['message' => 'Invalid foreignId'], 400);}

        $validator = validator::make($request->all(), [
            'Monitor'=> ['string', 'max:15', 'min:2'],
            'Keyboard'=> ['string', 'max:15', 'min:2'],
            'Mouse'=> ['string', 'max:15', 'min:2'],
            'Printer'=> ['string', 'max:15', 'min:2'],
            'UPS'=> ['string', 'max:15', 'min:2'],
            'cashBox'=> ['string', 'max:15', 'min:2'],
            'Barcode'=> ['string', 'max:15', 'min:2'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->all(), status: 400);
        }
        
        Peripheral::create([
            'Monitor'=> $request->Monitor,
            'Keyboard'=> $request->Keyboard,
            'Mouse'=> $request->Mouse,
            'Printer'=> $request->Printer,
            'UPS'=> $request->UPS,
            'cashBox'=> $request->cashBox,
            'Barcode'=> $request->Barcode,
            'device_id' => $deviceId,
        ]);

        return response()->json(['message' => 'Peripherals created successfully'], 200);
   
    }

    public function showPeripherals($deviceId){

        $peripheral = Peripheral::Where('device_id' , $deviceId)
        ->with('device:id,name')
        ->get();

        if ($peripheral->isEmpty())
         {
            return response()->json(['message' => 'no Peripherals added'], 404);
         }

        return response()->json($peripheral, 200);
    }

    public function editPeripherals(Request $request , $id){

        $validator = validator::make($request->all(), [
            'Monitor'=> ['sometimes','string', 'max:15', 'min:2'],
            'Keyboard'=> ['sometimes','string', 'max:15', 'min:2'],
            'Mouse'=> ['sometimes','string', 'max:15', 'min:2'],
            'Printer'=> ['sometimes','string', 'max:15', 'min:2'],
            'UPS'=> ['sometimes','string', 'max:15', 'min:2'],
            'cashBox'=> ['sometimes','string', 'max:15', 'min:2'],
            'Barcode'=> ['sometimes','string', 'max:15', 'min:2'],
            'updated_at' => now(),
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->all(), status: 400);
        }

        $peripheral = Peripheral::find($id);
        if (! $peripheral) {
            return response()->json(['message' => 'Peripherals not found'], 404);
        }

        $peripheral->update($request->all());

        return response()->json(['message' => 'Peripherals Updated successfully'], 200);
    }

    public function deletePeripheral($id){

        $peripheral = Peripheral::find($id);
        if (! $peripheral) {
            return response()->json(['message' => 'Peripherals not found'], 404);
        }

        $peripheral->delete();
        return response()->json(['message' => 'Peripherals Deleted successfully'], 200);
    }
}
