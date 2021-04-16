<?php

namespace App\Http\Controllers;

use App\Http\Resources\ClientResource;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Inertia\Response;

class ClientController extends Controller
{

    public function index(Request $request): Response
    {
        $clients = Client::all();

        return inertia('Client/Index', [
            'clients' => ClientResource::collection($clients),
            'created' => $request->session()->get('created', null)
        ]);
    }

    public function show(Request $request, $id): Response
    {
        $client = Client::findOrFail($id);

        return inertia('Client/View', [
            'client' => $client
        ]);
    }

    public function store(Request $request): RedirectResponse
    {

        $this->validate($request, [
            "name" => "required|string",
            "status" => "required|in:Active,Inactive"
        ]);

        $client = new Client;
        $client->name = $request->get("name");
        $client->status = $request->get("status");
        $client->save();

        return Redirect::route('clients')->with([
            'created' => $client
        ]);
    }

}
