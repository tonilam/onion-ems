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

}
