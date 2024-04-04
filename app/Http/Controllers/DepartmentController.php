<?php
namespace App\Http\Controllers;
use App\Models\Department;
use App\Models\Floor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DepartmentController extends Controller {

    public function createDepartment(Request $request,$floorId){

        $foreignId = Floor::find($floorId);
        if (!$foreignId) {return response()->json(['message' => 'Invalid foreignId'], 400);}

        $validator = validator::make($request->all(), [
            'name' => ['required', 'string', 'max:15', 'min:2'],
            'Note' => ['string', 'max:255', 'min:2'],
        ]);
        

        if ($validator->fails()) {
            return response()->json($validator->errors()->all(), status: 400);
        }

        Department::create([
            'name' => $request->name,
            'Note' => $request->Note,
            'floor_id' => $floorId,

        ]);

        return response()->json(['message' => 'Department created successfully'], 200);
    
    }
    public function showDepartments(){

        $departments = Department::With( 'floor:id,name')->get();

        if ($departments->isEmpty())
         {
            return response()->json(['message' => 'no Department added'], 404);
         }

        return response()->json($departments, 200);
    }

    public function departmentsInFloor($floorId){

        $departments = Department::Where('floor_id' , $floorId)->With( 'floor:id,name')->get();

        if ($departments->isEmpty())
         {
            return response()->json(['message' => 'no Department added'], 404);
         }

        return response()->json($departments, 200);
    }

    public function getDepartment($departmentId){

        $department = Department::Where('id',$departmentId)->With( 'floor:id,name')->get();

        if ($department->isEmpty())
        {
           return response()->json(['message' => 'no Department added'], 404);
        }

        return response()->json($department, 200);
    }

    public function editDepartment(Request $request , $id) {

        $validator = validator::make($request->all(), [
            'name' => ['sometimes','string', 'max:15', 'min:2'],
            'floor_id' => ['sometimes','integer'],
            'Note' => ['sometimes','string', 'max:255', 'min:2'],
            'updated_at' => now(),
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->all(), status: 400);
        }

        $department = Department::find($id);
        if (! $department) {
            return response()->json(['message' => 'Department not found'], 404);
        }

        $department->update($request->all());

        return response()->json(['message' => 'Department Updated successfully'], 200);
    }

    public function deleteDepartment($id){

        $department = Department::find($id);
        if (! $department) {
            return response()->json(['message' => 'Department not found'], 404);
        }

        $department->delete();
        return response()->json(['message' => 'Department Deleted successfully'], 200);
    }    


    
}
