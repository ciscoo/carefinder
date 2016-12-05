<?php

namespace App\Http\Services;

use App\Hospital;
use Illuminate\Database\Eloquent\Collection;
use App\Key;

class KeyService
{
    public function generateKey(): string
    {
        return chr(mt_rand(ord( 'a' ), ord( 'z' ))) . substr(md5(time()), 1);
    }

    public function saveKey(string $key): ?Key
    {        
        $instance = Key::where('secret', $key)->first();
        if (!$instance) {
            $instance = new Key(['secret' => $key]);
            $instance->save();
        }
        return $instance;
    }

    public function deleteKey(string $key)
    {
        $instance = Key::where('secret', $key)->first();
        if (!$instance) {
            return ['error' => 404];
        }
        if (!$instance->delete()) {
            return ['error' => 500];
        }
        return ['error' => true];
    }

    public function createLevel(string $key, string $level)
    {
        $instance = Key::where('secret', $key)->first();
        if (!$instance) {
            return null;
        }
        $instance->level = $level;
        $instance->save();
        return $instance;
    }
}