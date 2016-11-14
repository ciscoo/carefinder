<?php

namespace App\Http\Services;

use App\Hospital;

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