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
    * Finds a resource by ID.
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

    /**
    * Finds a resource by city name.
    *
    * @return \Illuminate\Http\Response
    */
    public function showByCity(string $name)
    {
        $hospital = $this->hospitalService->getHospitalByCity($name);

        if ($hospital->isEmpty()) {
            return response('', 400);            
        } else {
            return response()->json($hospital);            
        }
    }

    /**
    * Deletes resource(s) by city name.
    *
    * @return \Illuminate\Http\Response
    */
    public function deleteByCity(string $name)
    {
        $hospital = $this->hospitalService->deleteHospitalByCity($name);

        if ($hospital) {
            return response('', 204);
        } else {
            return response('', 400);
        }
    }

    /**
    * Finds a resource by county name.
    *
    * @return \Illuminate\Http\Response
    */
    public function showByCounty(string $name)
    {
        $hospital = $this->hospitalService->getHospitalByCounty($name);

        if ($hospital->isEmpty()) {
            return response('', 400);            
        } else {
            return response()->json($hospital);            
        }
    }

    /**
    * Deletes resource(s) by county name.
    *
    * @return \Illuminate\Http\Response
    */
    public function deleteByCounty(string $name)
    {
        $hospital = $this->hospitalService->deleteHospitalByCounty($name);

        if ($hospital) {
            return response('', 204);
        } else {
            return response('', 400);
        }
    }

    /**
    * Finds a resource by state name.
    *
    * @return \Illuminate\Http\Response
    */
    public function showByState(string $name)
    {
        $hospital = $this->hospitalService->getHospitalByState($name);

        if ($hospital->isEmpty()) {
            return response('', 400);            
        } else {
            return response()->json($hospital);            
        }
    }

    /**
    * Deletes resource(s) by state name.
    *
    * @return \Illuminate\Http\Response
    */
    public function deleteByState(string $name)
    {
        $hospital = $this->hospitalService->deleteHospitalByState($name);

        if ($hospital) {
            return response('', 204);
        } else {
            return response('', 400);
        }
    }
}
