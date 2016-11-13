<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class HospitalTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $hospitals = $this->loadXML();

        foreach($hospitals as $hospital) {
            DB::table('hospitals')->insert([
                'provider_id' => $hospital->provider_id,
                'name' => $hospital->hospital_name,
                'address' => $hospital->address,
                'city' => $hospital->city,
                'state' => $hospital->state,
                'zipcode' => $hospital->zip_code,
                'county' => $hospital->county_name,
                'phone' => $hospital->phone_number['phone_number'],
                'type' => $hospital->hospital_type,
                'ownership' => $hospital->hospital_ownership,
                'emergency_services' => (boolean) $hospital->emergency_services,
                'human_address' => $this->parseHumanAddress($hospital->location['human_address']),
                'latitude' => $hospital->location['latitude'],
                'longitude' => $hospital->location['longitude'],
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
        }
    }

    /**
     * Attempts to load the hospital xml file.
     *
     * @return null|SimpleXMLElement
     */
    public function loadXML() : ?SimpleXMLElement
    {
        $path = resource_path('assets/database/ushospitals.xml');
        return file_exists($path) ? simplexml_load_file($path)->row[0] : null;
    }

    /**
     * The human address from the provided hospital xml is JSON encoded.
     * This method will decode the JSON and return the values separated
     * by a single comma.
     *
     * @param string $humanAddress - The JSON encoded human address
     * @return string - The decoded human address
     */
    public function parseHumanAddress(string $humanAddress) : string
    {
        $decodedAddress = json_decode($humanAddress, true);
        $address = implode(", ", $decodedAddress);

        return $address;
    }
}
