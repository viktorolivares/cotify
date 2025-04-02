<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Inertia\Response;
use Inertia\Inertia;

// Models
use App\Models\Catalogs\Department;
use App\Models\Catalogs\District;
use App\Models\Catalogs\Province;
use App\Models\Catalogs\Template;
use App\Models\Company;
use App\Models\Account;


class CompaniesController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Companies/Index', [
            'filters' => Request::all(['search', 'trashed']),
            'companies' => Auth::user()->account->companies()
                ->orderBy('name')
                ->filter(Request::only(['search', 'trashed']))
                ->paginate(10)
                ->withQueryString()
                ->through(fn($company) => [
                    'id' => $company->id,
                    'name' => $company->name,
                    'trade_name' => $company->trade_name,
                    'number' => $company->number,
                    'phone' => $company->phone,
                    'email' => $company->email,
                    'deleted_at' => $company->deleted_at,
                ]),
        ]);
    }

    public function create(): Response
    {
        $departments = Department::all(['id', 'description']);
        $provinces = Province::all(['id', 'description', 'department_id']);
        $districts = District::all(['id', 'description', 'province_id']);
        $templates = Template::all(['id', 'description']);
        $accounts = Account::all(['id', 'name']);

        return Inertia::render('Companies/Create', [
            'departments' => $departments,
            'templates' => $templates,
            'accounts' => $accounts,
            'provinces' => $provinces,
            'districts' => $districts,
        ]);
    }

    public function store(): RedirectResponse
    {
        Request::validate([
            'account_id' => ['required', 'exists:accounts,id'],
            'identity_document_type_id' => ['required', 'exists:identity_document_types,id'],
            'number' => ['required', 'max:20'],
            'name' => ['required', 'max:100'],
            'email' => ['nullable', 'max:50', 'email'],
            'phone' => ['nullable', 'max:50'],
            'address' => ['nullable', 'max:150'],
            'trade_name' => ['nullable', 'max:100'],
            'department_id' => ['required', 'exists:departments,id'],
            'province_id' => ['required', 'exists:provinces,id'],
            'district_id' => ['required', 'exists:districts,id'],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png'],
            'template_id' => ['required', 'exists:templates,id'],
        ]);

        $company = Auth::user()->account->companies()->create([
            'account_id' => Request::get('account_id'),
            'identity_document_type_id' => Request::get('identity_document_type_id'),
            'number' => Request::get('number'),
            'name' => Request::get('name'),
            'email' => Request::get('email'),
            'phone' => Request::get('phone'),
            'address' => Request::get('address'),
            'trade_name' => Request::get('trade_name'),
            'department_id' => Request::get('department_id'),
            'province_id' => Request::get('province_id'),
            'district_id' => Request::get('district_id'),
            'template_id' => Request::get('template_id'),
            'logo_path' => Request::file('logo') ? Request::file('logo')->store('logos') : null,
        ]);

        $company->establishments()->create([
            'description' => 'OFICINA PRINCIPAL - '.Request::get('name'),
            'code' => '0000',
            'email' => Request::get('email'),
            'address' => Request::get('address'),
            'phone' => Request::get('phone'),
            'department_id' => Request::get('department_id'),
            'province_id' => Request::get('province_id'),
            'district_id' => Request::get('district_id'),
        ]);

        return Redirect::route('companies')->with('success', 'Company created.');
    }

    public function edit(Company $company): Response
    {
        $departments = Department::all(['id', 'description']);
        $provinces = Province::all(['id', 'description', 'department_id']);
        $districts = District::all(['id', 'description', 'province_id']);
        $templates = Template::all(['id', 'description']);
        $accounts = Account::all(['id', 'name']);

        return Inertia::render('Companies/Edit', [
            'company' => [
                'id' => $company->id,
                'account_id' => $company->account_id,
                'identity_document_type_id' => $company->identity_document_type_id,
                'number' => $company->number,
                'name' => $company->name,
                'trade_name' => $company->trade_name,
                'email' => $company->email,
                'phone' => $company->phone,
                'address' => $company->address,
                'department_id' => $company->department_id,
                'province_id' => $company->province_id,
                'district_id' => $company->district_id,
                'template_id' => $company->template_id,
                'deleted_at' => $company->deleted_at,
                'logo' => $company->logo_path ? URL::route('image', ['path' => $company->logo_path, 'w' => 100]) : null,
                'establishments' => $company->establishments->map(function ($establishment) {
                    return [
                        'id' => $establishment->id,
                        'description' => $establishment->description,
                        'code' => $establishment->code,
                        'address' => $establishment->address,
                        'email' => $establishment->email,
                    ];
                }),
            ],
            'departments' => $departments,
            'provinces' => $provinces,
            'districts' => $districts,
            'templates' => $templates,
            'accounts' => $accounts,
        ]);
    }


    public function update(Company $company): RedirectResponse
    {
        Request::validate([
            'account_id' => ['required', 'exists:accounts,id'],
            'identity_document_type_id' => ['required', 'exists:identity_document_types,id'],
            'number' => ['required', 'max:20'],
            'name' => ['required', 'max:100'],
            'email' => ['nullable', 'max:50', 'email'],
            'phone' => ['nullable', 'max:50'],
            'address' => ['nullable', 'max:150'],
            'trade_name' => ['nullable', 'max:100'],
            'department_id' => ['required', 'exists:departments,id'],
            'province_id' => ['required', 'exists:provinces,id'],
            'district_id' => ['required', 'exists:districts,id'],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png'],
            'template_id' => ['required', 'exists:templates,id'],
        ]);

        $company->update(Request::only([
            'account_id',
            'identity_document_type_id',
            'number',
            'name',
            'email',
            'phone',
            'address',
            'trade_name',
            'department_id',
            'province_id',
            'district_id',
            'template_id',
        ]));

        if (Request::hasFile('logo')) {
            $company->update(['logo_path' => Request::file('logo')->store('logos')]);
        }

        return Redirect::back()->with('success', 'Company updated.');
    }

    public function destroy(Company $Company): RedirectResponse
    {
        $Company->delete();

        return Redirect::back()->with('success', 'Company deleted.');
    }

    public function restore(Company $Company): RedirectResponse
    {
        $Company->restore();

        return Redirect::back()->with('success', 'Company restored.');
    }

    public function getCompanies()
    {
        $companies = Company::orderBy('name', 'asc')->get(['id', 'name', 'trade_name']);
        return response()->json($companies);
    }

}
