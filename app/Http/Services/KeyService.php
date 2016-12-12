<?php

namespace App\Http\Services;

use App\Hospital;
use Illuminate\Database\Eloquent\Collection;
use App\Key;

class KeyService
{
    /**
     * Generates a unique random key.
     *
     * @return string - The API key
     */
    public function generateKey(): string
    {
        return chr(mt_rand(ord( 'a' ), ord( 'z' ))) . substr(md5(time()), 1);
    }

    /**
     * Saves an arbitrary string to the database that serves as an API key.
     *
     * @param string $key - The API key to save.
     * @return Key|null - A Key instance or null.
     */
    public function saveKey(string $key): ?Key
    {        
        $instance = Key::where('secret', $key)->first();
        if (!$instance) {
            $instance = new Key(['secret' => $key]);
            $instance->save();
        }
        return $instance;
    }

    /**
     * Deletes an API key from the database.
     *
     * @param string $key - The Key to delete.
     * @return array - An array that states any errors.
     */
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

    /**
     * Create a level for a given API key.
     *
     * @param string $key - The API secret string.$_COOKIE
     * @param string $level - The level to persist for an API key.
     * @return Key - A new Key instance or existing instance.
     */
    public function createLevel(string $key, string $level)
    {
        $instance = Key::where('secret', $key)->first();
        if (!$instance) {
            $instance = new Key(['secret' => $key]);
        }
        $instance->level = $level;
        $instance->save();
        return $instance;
    }
}