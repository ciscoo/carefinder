<?php

namespace App\Http\Services;

use App\Hospital;
use Illuminate\Database\Eloquent\Collection;

class HospitalService
{
    /**
     * Creates a new Hospital instance.
     *
     * @param array $data - The JSON data from the request.
     * @return Hospital - The newly created instance.
     */
    public function createHospital(array $data) : ?Hospital
    {
        if (array_key_exists('emergency_services', $data)) {
            $data['emergency_services'] = $this->fixEmergencyServices($data['emergency_services']);
        }
        if (array_key_exists('human_address', $data)) {
            $data['human_address'] = $this->parseHumanAddress($data['human_address']);
        }
        $instance = new Hospital($data);
        $instance->save();
        
        return $instance;
    }

    /**
     * Deletes all hospital entries.
     *
     * @return object - All deleted hospitals
     */
    public function dropAllHospitals()
    {
        $hospitals = Hospital::all();
        Hospital::getQuery()->delete();
        return $hospitals;
    }

    /**
     * Retrieves a hospital by a given ID.
     *
     * @return null|Hospital - The found Hospital or null.
     */
    public function getHospitalById(string $id) : ?Hospital
    {
        $instance = null;

        // If the ID contains letters, find by provider_id,
        // otherwise find by ID.
        if (preg_match('/[a-z]/i', $id)) {
            $instance = Hospital::where('provider_id', $id)->first();
        } else {
            $instance = Hospital::where('id', $id)->first();
        }

        return $instance;
    }

    /**
     * Updates an existing resource or creates it.
     *
     * @return null|Hospital - The updated or created Hospital otherwise null.
     */
    public function updateOrCreateHospitalById(string $id, array $data = null) : ?Hospital
    {
        if ($data) {
            if (array_key_exists('emergency_services', $data)) {
                $data['emergency_services'] = $this->fixEmergencyServices($data['emergency_services']);
            }
            if (array_key_exists('human_address', $data)) {
                $data['human_address'] = $this->parseHumanAddress($data['human_address']);
            }
        } else {
            return null;
        }

        $instance = null;

        // If the ID contains letters, find by provider_id,
        // otherwise find by ID.
        if (preg_match('/[a-z]/i', $id)) {
            $instance = Hospital::where('provider_id', $id)->first();
        } else {
            $instance = Hospital::where('id', $id)->first();
        }


        if ($instance) {
            $instance->fill($data)->save();
        } else {
            $instance = new Hospital($data);
            $instance->save();
        }

        return $instance;
    }

    /**
     * Deletes an existing resource if exists.
     *
     * @return boolean - True if succesfully deleted.
     */
    public function deleteById($id)
    {
        $instance = null;

        // If the ID contains letters, find by provider_id,
        // otherwise find by ID.
        if (preg_match('/[a-z]/i', $id)) {
            $instance = Hospital::where('provider_id', $id)->first();
        } else {
            $instance = Hospital::where('id', $id)->first();
        }

        if ($instance->delete()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Retrieves a hospital by a given city name.
     *
     * @return Collection - The found Hospital(s) otherwise empty.
     */
    public function getHospitalByCity(string $name) : Collection
    {
        return Hospital::where('city', $name)->get();
    }

    /**
     * Deletes hospital(s) by a given city name.
     *
     * @return int - The number of deleted Hospital(s) otherwise empty.
     */
    public function deleteHospitalByCity(string $name)
    {
        return Hospital::query()->where('city', $name)->delete();
    }

    /**
     * Retrieves a hospital by a given county name.
     *
     * @return Collection - The found Hospital(s) otherwise empty.
     */
    public function getHospitalByCounty(string $name) : Collection
    {
        return Hospital::where('county', $name)->get();
    }

    /**
     * Deletes hospital(s) by a given county name.
     *
     * @return int - The number of deleted Hospital(s) otherwise empty.
     */
    public function deleteHospitalByCounty(string $name)
    {
        return Hospital::query()->where('county', $name)->delete();
    }

    /**
     * Deletes hospital(s) by a given state name.
     *
     * @return int - The number of deleted Hospital(s) otherwise empty.
     */
    public function deleteHospitalByState(string $name)
    {
        return Hospital::query()->where('state', $name)->delete();
    }

    /**
     * Retrieves a hospital by a given state name.
     *
     * @return Collection - The found Hospital(s) otherwise empty.
     */
    public function getHospitalByState(string $name) : Collection
    {
        return Hospital::where('state', $name)->get();
    }

    /**
     * Deletes hospital(s) by a given state and city name.
     *
     * @return int - The number of deleted Hospital(s) otherwise empty.
     */
    public function deleteHospitalByStateCity(string $state, string $city)
    {
        return Hospital::query()
            ->where('state', $state)
            ->where('city', $city)
            ->delete();
    }

    /**
     * Retrieves a hospital by a given state and city name.
     *
     * @return Collection - The found Hospital(s) otherwise empty.
     */
    public function getHospitalByStateCity(string $state, string $city) : Collection
    {
        return Hospital::query()
            ->where('state', $state)
            ->where('city', $city)
            ->get();
    }

    /**
     * Deletes hospital(s) by a given name.
     *
     * @return int - The number of deleted Hospital(s) otherwise empty.
     */
    public function deleteHospitalByName(string $name)
    {
        return Hospital::query()->where('name', $name)->delete();
    }

    /**
     * Retrieves a hospital by a given state name.
     *
     * @return Collection - The found Hospital(s) otherwise empty.
     */
    public function getHospitalByName(string $name) : Collection
    {
        return Hospital::where('name', $name)->get();
    }

    /**
     * Deletes hospital(s) by a given type.
     *
     * @return int - The number of deleted Hospital(s) otherwise empty.
     */
    public function deleteHospitalByType(string $type)
    {
        return Hospital::query()->where('type', $type)->delete();
    }

    /**
     * Retrieves a hospital by a given type.
     *
     * @return Collection - The found Hospital(s) otherwise empty.
     */
    public function getHospitalByType(string $type) : Collection
    {
        return Hospital::where('type', $type)->get();
    }

    /**
     * Deletes hospital(s) by a given owner.
     *
     * @return int - The number of deleted Hospital(s) otherwise empty.
     */
    public function deleteHospitalByOwner(string $owner)
    {
        return Hospital::query()->where('ownership', $owner)->delete();
    }

    /**
     * Retrieves a hospital by a given owner.
     *
     * @return Collection - The found Hospital(s) otherwise empty.
     */
    public function getHospitalByOwner(string $owner) : Collection
    {
        return Hospital::where('ownership', $owner)->get();
    }

    /**
     * Deletes hospital(s) by a given emergency.
     *
     * @return int - The number of deleted Hospital(s) otherwise empty.
     */
    public function deleteHospitalByemergency(string $emergency)
    {
        $emergency = $this->fixEmergencyServices($emergency);
        return Hospital::query()->where('emergency_services', $emergency)->delete();
    }

    /**
     * Retrieves a hospital by a given emergency.
     *
     * @return Collection - The found Hospital(s) otherwise empty.
     */
    public function getHospitalByemergency(string $emergency) : Collection
    {
        $emergency = $this->fixEmergencyServices($emergency);
        return Hospital::where('emergency_services', $emergency)->get();
    }

    /**
     * Deletes hospital(s) by a given distance.
     *
     * @return int - The number of deleted Hospital(s) otherwise empty.
     */
    public function deleteHospitalByDistance(string $latitude, string $longitude, string $distance)
    {
        $hospitals = $this->filterHospitalsByDistance($latitude, $longitude, $distance);
        $success = true;

        foreach ($hospitals as $hospital) {
            $hospital->delete();
        }

        return $hospitals;
    }

    /**
     * Retrieves a hospital by a given emergency.
     *
     * @return Collection - The found Hospital(s) otherwise empty.
     */
    public function getHospitalByDistance(string $latitude, string $longitude, string $distance)
    {
        return $this->filterHospitalsByDistance($latitude, $longitude, $distance);
    }


    public function filterHospitalsByDistance(string $latitude, string $longitude, string $distance, $delete = false)
    {
        $distance = intval($distance);
        $earthRadius = 3961;
        $latitudeInitial = deg2rad((float) $latitude);
        $longitudeInitial = deg2rad((float) $longitude);
        $hospitals = Hospital::all();
        $filtered = [];

        foreach ($hospitals as $hospital) {
            $validDistance = $this->calculateDistance($hospital, $latitude, $longitude, $distance);
            if ($validDistance) {
                $filtered[] = $hospital;
            }
        }

        if ($delete) {
            dd($filtered);
        }

        return collect($filtered);
    }

    /**
     * Caluclates the distance between hospitals in miles.
     * 
     * Based on JS code from http://andrew.hedges.name/experiments/haversine/
     *
     * @return array - The hospitals within a valid distance.
     */
    private function calculateDistance(Hospital $hospital, float $latitude, float $longitude, int $distance) : int
    {
        $meanEarthRadius = 3961;
        $latitude = deg2rad($latitude);
        $longitude = deg2rad($longitude);
        $hospitalLat = deg2rad($hospital->latitude);
        $hospitalLon = deg2rad($hospital->longitude);

        $dlon = $hospitalLon - $longitude;
        $dlat = $hospitalLat - $latitude;
        $a = pow((sin($dlat/2)), 2) + cos($latitude) * cos($hospitalLat) * pow((sin($dlon/2)), 2);
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        $d = $meanEarthRadius * $c;

        return floor($d) <= $distance;
    }

    /**
     * Convert the string to boolean.
     *
     * @param string $str - The string containing true or false
     * @return string - The boolean value of the non-empty string
     */
    private function fixEmergencyServices(string $str)
    {
        return $str === 'true' ? true : false;
    }

    /**
     * The human address from the provided hospital xml is JSON encoded.
     * This method will decode the JSON and return the values separated
     * by a single comma.
     *
     * @param string $humanAddress - The JSON encoded human address
     * @return string - The decoded human address
     */
    private function parseHumanAddress(string $humanAddress) : string
    {
        $decodedAddress = json_decode($humanAddress, true);
        $address = implode(", ", $decodedAddress);

        return $address;
    }
}