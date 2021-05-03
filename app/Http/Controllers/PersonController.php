<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Inertia\Response;

class PersonController extends Controller
{

    public function index(Request $request)
    {
        $people = Person::paginate();

        $response = [
            // Web View
            0 => inertia('Client/Index', [
                'people' => $people
            ]),
            // Json Response
            1 => $people
        ];

        return $response[request()->expectsJson()];
    }

    public function show(Request $request, $id)
    {
        $person = Person::findOrFail($id);

        $response = [
            // Web View
            0 => inertia('Person/View', ['person' => $person]),
            // Json Response
            1 => $person
        ];

        return $response[request()->expectsJson()];
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required'
        ]);

        $person = new Person;
        $person->first_name = $request->get('first_name');
        $person->middle_name = $request->get('middle_name');
        $person->last_name = $request->get('last_name');
        $person->gender = $request->get('gender', 'Unknown');
        $person->save();

        return $this->resolve();
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'first_name' => 'required'
        ]);

        $person = Person::findOrFail($id);
        $person->first_name = $request->get('first_name');
        $person->middle_name = $request->get('middle_name');
        $person->last_name = $request->get('last_name');
        $person->gender = $request->get('gender', 'Unknown');
        $person->dob = $request->get('dob');
        $person->save();

        return $this->resolve();
    }

}
