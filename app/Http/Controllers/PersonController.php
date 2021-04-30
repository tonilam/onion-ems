<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Inertia\Response;

class PersonController extends Controller
{

    public function index(Request $request): Response
    {

    }

    public function show(Request $request, $id): Response
    {

    }

    public function store(Request $request): RedirectResponse
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

        return Redirect::back();
    }

    public function update(Request $request, $id): RedirectResponse
    {

    }

}
