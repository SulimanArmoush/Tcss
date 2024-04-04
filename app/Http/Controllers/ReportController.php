<?php

namespace App\Http\Controllers;
use App\Models\MaintenanceService;
use App\Models\User;
use App\Models\Department;
use App\Models\InstallationService;
use App\Models\Device;
use App\Models\Peripheral;
use App\Models\Property;

use App\Exports\MaintenanceServiceExport;
use App\Exports\MaintenanceOfDepartment;
use App\Exports\MaintenanceOfUser;
use App\Exports\InstallationServiceExport;
use App\Exports\InstallationOfUser;
use App\Exports\InstallationOfDepartment;
use App\Exports\MaterialReport;
use App\Exports\HardeareKeyReport;
use App\Exports\DeviceReport;
use App\Exports\ComputersReport;
use App\Models\Hardwarekey;
use App\Models\Material;
use Maatwebsite\Excel\Facades\Excel; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{
    public function exportMaintenanceService (Request $request) {

        $validator = validator::make($request->all(), [
            'startDate' => ['date'],
            'endDate' => ['date'],
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->all(), status: 400);
        }
    
        $startDate = $request->startDate ?? MaintenanceService::orderBy('created_at')->first()->created_at->toDateString();
        $endDate = $request->endDate ?? MaintenanceService::orderBy('created_at', 'desc')->first()->created_at->toDateString();
    
        $fileName ='Maintenance-Report-from-'.$startDate.'-To-'.$endDate.'.xlsx';
        return Excel::download(new MaintenanceServiceExport($startDate, $endDate), $fileName);
    }

    public function exportMaintenanceOfUser (Request $request) {

        $validator = validator::make($request->all(), [
            'startDate' => ['date'],
            'endDate' => ['date'],
            'user' => ['required','integer'],
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->all(), status: 400);
        }
        $userId = $request->user ;
        $user = User::find($userId);
        $startDate = $request->startDate ?? MaintenanceService::where('user_id', $userId)->orderBy('created_at')->first()->created_at->toDateString();
        $endDate = $request->endDate ?? MaintenanceService::where('user_id', $userId)->orderBy('created_at', 'desc')->first()->created_at->toDateString();
    
        $fileName = $user->name.'-from-'.$startDate.'-To-'.$endDate.'-Maintenance-Report.xlsx';
        return Excel::download(new MaintenanceOfUser($startDate, $endDate, $user), $fileName);
    }

    public function exportMaintenanceOfDepartment (Request $request) {

        $validator = validator::make($request->all(), [
            'startDate' => ['date'],
            'endDate' => ['date'],
            'department' => ['required','integer'],
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->all(), status: 400);
        }

        $departmentId = $request->department;
        $department = Department::find($departmentId);
        $startDate = $request->startDate ?? MaintenanceService::where('department_id', $departmentId)->orderBy('created_at')->first()->created_at->toDateString();
        $endDate = $request->endDate ?? MaintenanceService::where('department_id', $departmentId)->orderBy('created_at', 'desc')->first()->created_at->toDateString();
    
        $fileName = $department->name.'-from-'.$startDate.'-To-'.$endDate.'-Maintenance-Report.xlsx';
        return Excel::download(new MaintenanceOfDepartment($startDate, $endDate, $department), $fileName);
    }

    public function exportInstallationService (Request $request) {

        $validator = validator::make($request->all(), [
            'startDate' => ['date'],
            'endDate' => ['date'],
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->all(), status: 400);
        }
    
        $startDate = $request->startDate ?? InstallationService::orderBy('created_at')->first()->created_at->toDateString();
        $endDate = $request->endDate ?? InstallationService::orderBy('created_at', 'desc')->first()->created_at->toDateString();
    
        $fileName ='Installation-Report-from-'.$startDate.'-To-'.$endDate.'.xlsx';
        return Excel::download(new InstallationServiceExport($startDate, $endDate), $fileName);
    }

    public function exportInstallationOfUser (Request $request) {

        $validator = validator::make($request->all(), [
            'startDate' => ['date'],
            'endDate' => ['date'],
            'user' => ['required','integer'],
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->all(), status: 400);
        }
        $userId = $request->user ;
        $user = User::find($userId);
        $startDate = $request->startDate ?? InstallationService::where('user_id', $userId)->orderBy('created_at')->first()->created_at->toDateString();
        $endDate = $request->endDate ?? InstallationService::where('user_id', $userId)->orderBy('created_at', 'desc')->first()->created_at->toDateString();
    
        $fileName = $user->name.'-from-'.$startDate.'-To-'.$endDate.'-Installation-Report.xlsx';
        return Excel::download(new InstallationOfUser($startDate, $endDate, $user), $fileName);
    }

    public function exportInstallationOfDepartment (Request $request) {

        $validator = validator::make($request->all(), [
            'startDate' => ['date'],
            'endDate' => ['date'],
            'department' => ['required','integer'],
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->all(), status: 400);
        }

        $departmentId = $request->department;
        $department = Department::find($departmentId);
        $startDate = $request->startDate ?? InstallationService::where('department_id', $departmentId)->orderBy('created_at')->first()->created_at->toDateString();
        $endDate = $request->endDate ?? InstallationService::where('department_id', $departmentId)->orderBy('created_at', 'desc')->first()->created_at->toDateString();
        
        $fileName = $department->name.'-from-'.$startDate.'-To-'.$endDate.'-Installation-Report.xlsx';
        return Excel::download(new InstallationOfDepartment($startDate, $endDate, $department), $fileName);
    }

    public function MaterialReport () {
        $fileName = 'Material-'.today()->format('d-m-Y').'-Report.xlsx';
        return Excel::download(new MaterialReport, $fileName);
    }

    public function HardeareKeyReport () {
        $fileName = 'HardeareKey-'.today()->format('d-m-Y').'-Report.xlsx';
        return Excel::download(new HardeareKeyReport, $fileName);
    }
    public function DeviceReport (Request $request) {

        $validator = validator::make($request->all(), [
            'device' => ['required','integer'],
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->all(), status: 400);
        }
        $deviceId = $request->device;
        $Device = Device::find($deviceId);

        $fileName = $Device->name .'-'. today()->format('d-m-Y'). '-Device-Report.xlsx';
        return Excel::download(new DeviceReport($Device),$fileName);
    }

    public function ComputersReport () {
        $fileName = 'Computers-Report-'.today()->format('d-m-Y').'-.xlsx';
        return Excel::download(new ComputersReport, $fileName);
    }

    public function search(Request $request){
        $this->validate($request, [
            'keyword' => 'required',
            'model' => 'required|in:Department,Device,Hardwarekey,Material,Peripheral,Property',
        ]);
    
        $keyword = $request->keyword;
        $model = $request->model;
    
        $result = call_user_func("App\\Models\\$model::search", $keyword);
    
        if(count($result) <1)
        {
            return response()->json(['Not Found'], 404);
        }
        
        return response()->json($result, 200);
    }
    
}
