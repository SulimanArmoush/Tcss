<?php
namespace App\Http\Controllers;
use App\Models\Floor;

class FloorController extends Controller {

    public function showFloors(){

        $floors = Floor::Get();

        return response()->json($floors, 200);
    }

    public function getFloor($floorId){

        $floors = Floor::Where('id',$floorId)->get();

        return response()->json($floors, 200);
    }
}
