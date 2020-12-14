<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClientResource;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    function index()
    {
        return ClientResource::collection(Client::all());
    }


    function store(Request $request)
    {
        $this->validate($request, [
            "name" => "required|string",
            "status" => "required|in:Active,Inactive"
        ]);

        $client = new Client;
        $client->name = $request->get("name");
        $client->status = $request->get("status");
        $client->save();

        return new ClientResource($client);
    }
}
