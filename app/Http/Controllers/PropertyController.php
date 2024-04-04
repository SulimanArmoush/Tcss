<?php
namespace App\Http\Controllers;
use App\Models\Property;
use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PropertyController extends Controller{

    public function createProperty(Request $request , $deviceId){

        $foreignId = Device::find($deviceId);
        if (!$foreignId) {return response()->json(['message' => 'Invalid foreignId'], 400);}

        $validator = validator::make($request->all(), [
            'CPU'=> ['string', 'max:15', 'min:2'],
            'Motherboard'=> ['string', 'max:15', 'min:2'],
            'RAM'=> ['string', 'max:15', 'min:2'],
            'Hard'=> ['string', 'max:15', 'min:2'],
            'Graphics'=> ['string', 'max:15', 'min:2'],
            'powerSupply'=> ['string', 'max:15', 'min:2'],
            'OS'=> ['string', 'max:15', 'min:2'],
            'NIC'=> ['string', 'max:15', 'min:2'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->all(), status: 400);
        }
        
        Property::create([
            'CPU' => $request->CPU,
            'Motherboard' => $request->Motherboard,
            'RAM' => $request->RAM,
            'Hard' => $request->Hard,
            'Graphics' => $request->Graphics,
            'powerSupply' => $request->powerSupply,
            'OS' => $request->OS,
            'NIC' => $request->NIC,
            'device_id' => $deviceId,
        ]);

        return response()->json(['message' => 'Properties created successfully'], 200);
   
    }

    public function showProperties($deviceId){

        $property = Property::Where('device_id' , $deviceId)
        ->with('device:id,name')
        ->get();

        if ($property->isEmpty())
         {
            return response()->json(['message' => 'no Properties added'], 404);
         }

        return response()->json($property, 200);
    }

    public function editProperties(Request $request , $id){

        $validator = validator::make($request->all(), [
            'CPU'=> ['sometimes','string', 'max:15', 'min:2'],
            'Motherboard'=> ['sometimes','string', 'max:15', 'min:2'],
            'RAM'=> ['sometimes','string', 'max:15', 'min:2'],
            'Hard'=> ['sometimes','string', 'max:15', 'min:2'],
            'Graphics'=> ['sometimes','string', 'max:15', 'min:2'],
            'powerSupply'=> ['sometimes','string', 'max:15', 'min:2'],
            'OS'=> ['sometimes','string', 'max:15', 'min:2'],
            'NIC'=> ['sometimes','string', 'max:15', 'min:2'],
            'updated_at' => now(),
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->all(), status: 400);
        }

        $property = Property::find($id);
        if (! $property) {
            return response()->json(['message' => 'Properties not found'], 404);
        }

        $property->update($request->all());

        return response()->json(['message' => 'Properties Updated successfully'], 200);
    }

    public function deleteProperty($id) {

        $property = Property::find($id);
        if (! $property) {
            return response()->json(['message' => 'Properties not found'], 404);
        }

        $property->delete();
        return response()->json(['message' => 'Properties Deleted successfully'], 200);
    }

}
