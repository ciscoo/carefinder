<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\HospitalService;
use App\Hospital;

class HospitalController extends Controller
{
    /**
     * @var HospitalService
     */
    private $hospitalService;

    public function __construct(HospitalService $hospitalService)
    {
        $this->hospitalService = $hospitalService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Hospital::all());
    }

    /**
    * Creates a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function createHospital(Request $request)
    {
        $instance = $this->hospitalService->createHospital($request->json()->all());
        return response()->json($instance);
    }

    /**
    * Creates a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function deleteAllHospitals()
    {
        $hospitals = $this->hospitalService->dropAllHospitals();
        return response()->json($hospitals);
    }
}
