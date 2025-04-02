<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Catalogs\Department;
use App\Models\Catalogs\Province;

class LocationController extends Controller
{
    public function getDepartments()
    {
        $departments = Department::all(['id', 'description']);
        return response()->json($departments);
    }

    public function getProvinces(Department $department)
    {
        $provinces = $department->provinces;
        return response()->json($provinces);
    }

    public function getDistricts(Province $province)
    {
        $districts = $province->districts;
        return response()->json($districts);
    }
}