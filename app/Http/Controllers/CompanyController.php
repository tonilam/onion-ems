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

    public function show(Request $request, $id)
    {
        $company = Company::findOrFail($id);

        $response = [
            // Web View
            0 => inertia('Company/View', ['company' => $company]),
            // Json Response
            1 => $company
        ];

        return $response[request()->expectsJson()];
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        $company = new Company;
        $company->name = $request->get('name');
        $company->save();

        return $this->resolve();
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        $company = Company::findOrFail($id);
        $company->name = $request->get('name');
        $company->save();

        return $this->resolve();
    }

}
