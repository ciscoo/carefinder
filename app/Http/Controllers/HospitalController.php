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

    /**
    * Creates a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function show(string $id)
    {
        $hospital = $this->hospitalService->getHospitalById($id);
        return response()->json($hospital);
    }

    /**
    * Updates an existing resource or creates it.
    * If either failed, then no content is returned.
    *
    * @return \Illuminate\Http\Response
    */
    public function updateOrCreate(Request $request, string $id)
    {
        $data = $request->json()->all();
        $hospital = $this->hospitalService->updateOrCreateHospitalById($id, $data);

        if ($hospital) {
            return response()->json($hospital);

        } else {
            return response('', 400);
        }
    }

    /**
    * Updates an existing resource or creates it.
    * If either failed, then no content is returned.
    *
    * @return \Illuminate\Http\Response
    */
    public function deleteById(Request $request, string $id)
    {
        if ($this->hospitalService->deleteById($id)) {
            return response('', 204);
        } else {
            return response('', 400);
        }
    }
}
