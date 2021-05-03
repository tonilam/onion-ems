<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Inertia\Response;

class CompanyController extends Controller
{

    public function index(Request $request)
    {
        $companies = Company::paginate();

        $response = [
            // Web View
            0 => inertia('Client/Index', [
                'people' => $companies
            ]),
            // Json Response
            1 => $companies
        ];

        return $response[request()->expectsJson()];
    }

    public function show(Request $request, $id): Response
    {

    }

    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        $company = new Company;
        $company->name = $request->get('name');
        $company->save();

        return Redirect::back();
    }

    public function update(Request $request, $id): RedirectResponse
    {

    }

}
