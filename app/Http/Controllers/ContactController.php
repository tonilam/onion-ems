<?php

namespace App\Http\Controllers;

use App\Http\Resources\ContactResource;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{

    public function index(Request $request)
    {
        $query = Contact::query();

        if ($request->filled('company_id')) {
            $query->where('company_id', $request->get('company_id'));
        }

        if ($request->filled('person_id')) {
            $query->where('person_id', $request->get('person_id'));
        }

        $contacts = $query->paginate($request->get('per_page', 25));

        $response = [
            // Web View
            0 => inertia('Contact/Index', [
                'contacts' => ContactResource::collection($contacts)
            ]),
            // Json Response
            1 => ContactResource::collection($contacts)
        ];

        return $response[request()->expectsJson()];
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            "type" => "required|in:Phone,Fax,Email,Address",
            "content" => "required|string",
            "label" => "nullable|string",
            'person_id' => 'required_without:company_id|nullable|exists:people,id',
            'company_id' => 'required_without:person_id|nullable|exists:companies,id',
        ]);

        $contact = new Contact;
        $contact->company_id = $request->get("company_id");
        $contact->person_id = $request->get("person_id");
        $contact->type = $request->get("type");
        $contact->content = $request->get("content");
        $contact->label = $request->get("label");
        $contact->save();

        $response = [
            // Web View
            0 => inertia('Contact/View', [
                'contact' => new ContactResource($contact)
            ]),
            // Json Response
            1 => new ContactResource($contact)
        ];

        return $response[request()->expectsJson()];
    }

}
