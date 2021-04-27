<?php

namespace App\Http\Controllers;

use App\Http\Resources\ClientResource;
use App\Models\Client;
use App\Models\Company;
use App\Models\Person;
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
            'clients' => ClientResource::collection($clients)
        ]);
    }

    public function show(Request $request, $id): Response
    {
        $client = Client::findOrFail($id);
        $companies = Company::select('id', 'name')->get();
        $people = Person::select('id', 'first_name', 'last_name')->get();

        return inertia('Client/View', [
            'client' => $client,
            'companies' => $companies,
            'people' => $people,
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

        return Redirect::route('client.show', [
            'id' => $client->id
        ]);
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $this->validate($request, [
            "name"       => "required|string",
            "status"     => "required|in:Active,Inactive",
            "type"       => "required|in:Business,Individual",
            "company_id" => "nullable|exists:companies,id",
            "person_id"  => "nullable|exists:people,id"
        ]);

        $client = Client::findOrFail($id);
        $client->name = $request->get('name');
        $client->status = $request->get('status');
        if ($request->get('type') === 'Business') {
            $client->company_id = $request->get('company_id', null);
            $client->person_id = null;
        } else {
            $client->company_id = null;
            $client->person_id = $request->get('person_id', null);
        }
        $client->save();

        return Redirect::back();
    }

}
