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
        $data['emergency_services'] = $this->fixEmergencyServices($data['emergency_services']);
        $data['human_address'] = $this->parseHumanAddress($data['human_address']);
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