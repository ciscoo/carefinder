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
        $name = urldecode($name);
        $hospital = $this->hospitalService->getHospitalByCity($name);

        if ($hospital->isEmpty()) {
            return response('', 404);            
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
        $name = urldecode($name);
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
        $name = urldecode($name);
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
        $name = urldecode($name);
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
        $name = urldecode($name);
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
        $name = urldecode($name);
        $hospital = $this->hospitalService->deleteHospitalByState($name);

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
    public function showByStateCity(string $state, string $city)
    {
        $city = urldecode($city);
        $hospital = $this->hospitalService->getHospitalByStateCity($state, $city);

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
    public function deleteByStateCity(string $state, string $city)
    {
        $city = urldecode($city);
        $hospital = $this->hospitalService->deleteHospitalByStateCity($state, $city);

        if ($hospital) {
            return response('', 204);
        } else {
            return response('', 400);
        }
    }

    /**
    * Finds a resource by resource name.
    *
    * @return \Illuminate\Http\Response
    */
    public function showByName(string $name)
    {
        $name = urldecode($name);
        $hospital = $this->hospitalService->getHospitalByName($name);

        if ($hospital->isEmpty()) {
            return response('', 400);            
        } else {
            return response()->json($hospital);            
        }
    }

    /**
    * Deletes resource(s) by name.
    *
    * @return \Illuminate\Http\Response
    */
    public function deleteByName(string $name)
    {
        $name = urldecode($name);
        $hospital = $this->hospitalService->deleteHospitalByName($name);

        if ($hospital) {
            return response('', 204);
        } else {
            return response('', 400);
        }
    }

    /**
    * Finds a resource by resource type.
    *
    * @return \Illuminate\Http\Response
    */
    public function showByType(string $type)
    {
        $hospital = $this->hospitalService->getHospitalByType($type);

        if ($hospital->isEmpty()) {
            return response('', 400);            
        } else {
            return response()->json($hospital);            
        }
    }

    /**
    * Deletes resource(s) by type.
    *
    * @return \Illuminate\Http\Response
    */
    public function deleteByType(string $type)
    {
        $hospital = $this->hospitalService->deleteHospitalByType($type);

        if ($hospital) {
            return response('', 204);
        } else {
            return response('', 400);
        }
    }

    /**
    * Finds a resource by resource ownership.
    *
    * @return \Illuminate\Http\Response
    */
    public function showByOwner(string $owner)
    {
        $owner = urldecode($owner);
        $hospital = $this->hospitalService->getHospitalByOwner($owner);

        if ($hospital->isEmpty()) {
            return response('', 400);            
        } else {
            return response()->json($hospital);            
        }
    }

    /**
    * Deletes resource(s) by ownership.
    *
    * @return \Illuminate\Http\Response
    */
    public function deleteByOwner(string $owner)
    {
        $owner = urldecode($owner);
        $hospital = $this->hospitalService->deleteHospitalByOwner($owner);

        if ($hospital) {
            return response('', 204);
        } else {
            return response('', 400);
        }
    }

    /**
    * Finds a resource by resource emergency.
    *
    * @return \Illuminate\Http\Response
    */
    public function showByEmergency(string $emergency)
    {
        $hospital = $this->hospitalService->getHospitalByEmergency($emergency);

        if ($hospital->isEmpty()) {
            return response('', 400);            
        } else {
            return response()->json($hospital);            
        }
    }

    /**
    * Deletes resource(s) by emergency.
    *
    * @return \Illuminate\Http\Response
    */
    public function deleteByEmergency(string $emergency)
    {
        $hospital = $this->hospitalService->deleteHospitalByEmergency($emergency);

        if ($hospital) {
            return response('', 204);
        } else {
            return response('', 400);
        }
    }

    /**
    * Finds a resource by resource distance.
    *
    * @return \Illuminate\Http\Response
    */
    public function showByDistance(string $latitude, string $longitude, string $distance)
    {
        $hospitals = $this->hospitalService->getHospitalByDistance($latitude, $longitude, $distance);

        if ($hospitals->isEmpty()) {
            return response('', 400);            
        } else {
            return response()->json($hospitals);            
        }
    }

    /**
    * Deletes resource(s) by distance.
    *
    * @return \Illuminate\Http\Response
    */
    public function deleteByDistance(string $latitude, string $longitude, string $distance)
    {
        $hospitals = $this->hospitalService->deleteHospitalByDistance($latitude, $longitude, $distance);

        if ($hospitals) {
            return response('', 204);
        } else {
            return response('', 400);
        }
    }
}
