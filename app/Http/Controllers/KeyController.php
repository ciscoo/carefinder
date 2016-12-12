<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\KeyService;
use App\Key;

class KeyController extends Controller
{
    /**
     * @var KeyService
     */
    private $keyService;

    public function __construct(KeyService $keyService)
    {
        $this->keyService = $keyService;
    }

    /**
     * Displays detailed listing of all API keys in the database or
     * a specified key.
     *
     * @param string|null - A specific API key to show details for.
     * @return \Illuminate\Http\Response
     */
    public function index(string $key = null)
    {
        if (!$key) {
            return response()->json(Key::all());        
        }
        return response()->json(Key::where('secret', $key));
    }

    /**
     * Generates a fresh API key.
     *
     * @return \Illuminate\Http\Response
     */
    public function get()
    {
        $secret = $this->keyService->generateKey();
        return response()->json(['key' => $secret]);
    }

    /**
     * Saves an API key to the database.
     *
     * @return \Illuminate\Http\Response
     */
    public function save(string $key)
    {
        $instance = $this->keyService->saveKey($key);
        return response()->json($instance);
    }

    /**
     * Deletes an API key from the database.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(string $key)
    {
        $resp = $this->keyService->deleteKey($key);
        if ($resp['error'] === 404) {
            return response()->json(['error' => 'No such key exists.'], 404);
        } else if ($resp['error'] === 500) {
            return response()->json(['error' => 'Unable to delete key.'], 500);
        } else {
            return response('', 204);    
        }
    }

    /**
     * Persists a specified level for an API Key.
     *
     * @return \Illuminate\Http\Response
     */
    public function createLevel(string $key, string $level)
    {
        $instance = $this->keyService->createLevel($key, $level);
        return response()->json($instance);
    }
}
