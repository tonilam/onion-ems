<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Inertia\Response;

class ClientController extends Controller
{

    public function store(Request $request): Response
    {

        $this->validate($request, [
            "name" => "required|string",
            "status" => "required|in:Active,Inactive"
        ]);

        $client = new Client;
        $client->name = $request->get("name");
        $client->status = $request->get("status");
        $client->save();

        return inertia('Client/Index', [
            'newClient' => $client
        ]);
    }

}
