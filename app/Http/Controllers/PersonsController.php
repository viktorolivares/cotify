<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
use Inertia\Response;
use Inertia\Inertia;

// Models
use App\Models\Catalogs\Department;
use App\Models\Catalogs\District;
use App\Models\Catalogs\Province;
use App\Models\Person;

class PersonsController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Persons/Index', [
            'filters' => Request::all(['search', 'trashed']),
            'persons' => Person::orderBy('name')
                ->filter(Request::only(['search', 'trashed']))
                ->paginate(10)
                ->withQueryString()
                ->through(fn($person) => [
                    'id' => $person->id,
                    'number' => $person->number,
                    'name' => $person->name,
                    'trade_name' => $person->trade_name,
                    'address' => $person->address,
                    'created_at' => $person->created_at->diffForHumans(),
                    'deleted_at' => $person->deleted_at,
                ]),
        ]);
    }

    public function create(): Response
    {
        $departments = Department::all(['id', 'description']);
        $provinces = Province::all(['id', 'description', 'department_id']);
        $districts = District::all(['id', 'description', 'province_id']);

        return Inertia::render('Persons/Create', [
            'departments' => $departments,
            'provinces' => $provinces,
            'districts' => $districts,
        ]);
    }

    public function store(): RedirectResponse
    {
        Request::validate([
            'identity_document_type_id' => ['required', 'exists:identity_document_types,id'],
            'number' => ['required', 'max:20'],
            'name' => ['required', 'max:100'],
            'trade_name' => ['nullable', 'max:100'],
            'department_id' => ['required', 'exists:departments,id'],
            'province_id' => ['required', 'exists:provinces,id'],
            'district_id' => ['required', 'exists:districts,id'],
            'address' => ['nullable', 'max:255'],
            'email' => ['nullable', 'max:100', 'email', Rule::unique('persons')],
            'phone' => ['nullable', 'max:20'],
        ]);

        Person::create([
            'identity_document_type_id' => Request::get('identity_document_type_id'),
            'number' => Request::get('number'),
            'name' => Request::get('name'),
            'trade_name' => Request::get('trade_name'),
            'department_id' => Request::get('department_id'),
            'province_id' => Request::get('province_id'),
            'district_id' => Request::get('district_id'),
            'address' => Request::get('address'),
            'email' => Request::get('email'),
            'phone' => Request::get('phone'),
        ]);

        return Redirect::route('persons')->with('success', 'Person created.');
    }

    public function edit(Person $person): Response
    {
        $departments = Department::all(['id', 'description']);
        $provinces = Province::all(['id', 'description', 'department_id']);
        $districts = District::all(['id', 'description', 'province_id']);

        return Inertia::render('Persons/Edit', [
            'person' => [
                'id' => $person->id,
                'identity_document_type_id' => $person->identity_document_type_id,
                'number' => $person->number,
                'name' => $person->name,
                'trade_name' => $person->trade_name,
                'department_id' => $person->department_id,
                'province_id' => $person->province_id,
                'district_id' => $person->district_id,
                'address' => $person->address,
                'email' => $person->email,
                'phone' => $person->phone,
                'deleted_at' => $person->deleted_at
            ],
            'departments' => $departments,
            'provinces' => $provinces,
            'districts' => $districts,
        ]);
    }

    public function update(Person $person): RedirectResponse
    {
        Request::validate([
            'identity_document_type_id' => ['required', 'exists:identity_document_types,id'],
            'number' => ['required', 'max:20'],
            'name' => ['required', 'max:100'],
            'trade_name' => ['nullable', 'max:100'],
            'department_id' => ['required', 'exists:departments,id'],
            'province_id' => ['required', 'exists:provinces,id'],
            'district_id' => ['required', 'exists:districts,id'],
            'address' => ['nullable', 'max:255'],
            'email' => ['nullable', 'max:100', 'email', Rule::unique('persons')->ignore($person->id)],
            'phone' => ['nullable', 'max:20'],
        ]);

        $person->update(Request::only([
            'identity_document_type_id',
            'number',
            'name',
            'trade_name',
            'department_id',
            'province_id',
            'district_id',
            'address',
            'email',
            'phone'
        ]));

        return Redirect::back()->with('success', 'Person updated.');
    }


    public function destroy(Person $person): RedirectResponse
    {

        $person->delete();

        return Redirect::back()->with('success', 'Person deleted.');
    }

    public function restore(Person $person): RedirectResponse
    {
        $person->restore();

        return Redirect::back()->with('success', 'Person restored.');
    }

}
