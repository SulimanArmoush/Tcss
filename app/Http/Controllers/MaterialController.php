<?php
namespace App\Http\Controllers;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MaterialController extends Controller{

    public function createMaterial(Request $request){

        $validator = validator::make($request->all(), [
            'code' => ['string', 'max:25', 'min:1'],
            'name' => ['required','string','max:15', 'min:2'],
            'quantity' => ['integer'],
            'price' => ['numeric'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->all(), status: 400);
        }

        Material::create([
            'code' => $request->code,
            'name' => $request->name,
            'quantity' => $request->quantity,
            'price' => $request->price,
        ]);

        return response()->json(['message' => 'Material created successfully'], 200);
    }

    public function showMaterial(){
  
    $material = Material::Get();

        if ($material -> isEmpty())
         {
            return response()->json(['message' => 'no Materials added'], 404);
         }
        return response()->json($material, 200);
    }

    public function getMaterial($materialId){

        $material = Material::Where('id',$materialId)->get();

        if ($material->isEmpty())
        {
           return response()->json(['message' => 'no Materials added'], 404);
        }

        return response()->json($material, 200);
    }

    public function editMaterial(Request $request , $id){

        $validator = validator::make($request->all(), [
            'code' => ['sometimes','string', 'max:25', 'min:1'],
            'name' => ['sometimes','string','max:15', 'min:2'],
            'quantity' => ['sometimes','integer'],
            'price' => ['sometimes','numeric'],            
            'updated_at' => now(),
        ]);


            if ($validator->fails()) {
                return response()->json($validator->errors()->all(), status: 400);
            }
        $material = Material::find($id);
        if (! $material) {
            return response()->json(['message' => 'Material not found'], 404);
        }

        $material->update($request->all());

        return response()->json(['message' => 'Material Updated successfully'], 200);
    }

    public function deleteMaterial($id){

        $material = Material::find($id);
        if (! $material) {
            return response()->json(['message' => 'Material not found'], 404);
        }

        $material->delete();
        return response()->json(['message' => 'Material Deleted successfully'], 200);
    }

}
