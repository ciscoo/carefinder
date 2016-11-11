<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class HospitalTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $xml = $this->loadXML();
    
        foreach($xml->row[0] as $hospital) {
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
                'emergency_services' => (int) $hospital->emergency_services,
                'latitude' => $hospital->location['latitude'],
                'longitude' => $hospital->location['longitude']
            ]);
        }
    }

    public function loadXML() : ?SimpleXMLElement
    {
        $path = resource_path('assets/database/ushospitals.xml');

        if (file_exists($path)) {
            return simplexml_load_file($path);
        } else {
            return null;
        }
    }
}
