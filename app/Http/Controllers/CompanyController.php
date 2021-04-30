<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Inertia\Response;

class CompanyController extends Controller
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
