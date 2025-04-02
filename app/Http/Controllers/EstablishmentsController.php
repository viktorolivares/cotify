<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\Establishment;
use Inertia\Response;
use Inertia\Inertia;
use Throwable;

// Models
use App\Models\Catalogs\Department;
use App\Models\Catalogs\District;
use App\Models\Catalogs\Province;

class EstablishmentsController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Establishments/Index', [
            'filters' => Request::all(['search', 'enabled', 'with_deleted_companies']),
            'establishments' => Establishment::with([
                'company' => function ($query) {
                    $query->withTrashed();
                }
            ])
                ->orderByDescription()
                ->filter(Request::only(['search', 'enabled', 'with_deleted_companies']))
                ->paginate(10)
                ->withQueryString()
                ->through(fn($establishment) => [
                    'id' => $establishment->id,
                    'description' => $establishment->description,
                    'code' => $establishment->code,
                    'address' => $establishment->address,
                    'company' => $establishment->company->only('name', 'deleted_at'),
                    'deleted_at' => $establishment->deleted_at,
                    'enabled' => $establishment->enabled,
                ]),
        ]);
    }

    public function create(): Response
    {
        $departments = Department::all(['id', 'description']);
        $provinces = Province::all(['id', 'description', 'department_id']);
        $districts = District::all(['id', 'description', 'province_id']);

        return Inertia::render('Establishments/Create', [
            'companies' => Auth::user()->account
                ->companies()
                ->orderBy('name')
                ->get()
                ->map
                ->only('id', 'name'),

            'departments' => $departments,
            'provinces' => $provinces,
            'districts' => $districts,
        ]);
    }

    public function store(Establishment $establishment): RedirectResponse
    {

        Request::validate([
            'description' => ['required', 'max:150'],
            'address' => ['nullable', 'max:150'],
            'email' => ['nullable', 'max:50', 'email'],
            'phone' => ['nullable', 'max:50'],
            'code' => ['required', 'max:4'],
            'company_id' => ['required', 'exists:companies,id'],
            'department_id' => ['required', 'exists:departments,id'],
            'province_id' => ['required', 'exists:provinces,id'],
            'district_id' => ['required', 'exists:districts,id'],
        ]);

        $establishment->create([
            'description' => Request::input('description'),
            'address' => Request::input('address'),
            'email' => Request::input('email'),
            'phone' => Request::input('phone'),
            'code' => Request::input('code'),
            'company_id' => Request::input('company_id'),
            'department_id' => Request::input('department_id'),
            'province_id' => Request::input('province_id'),
            'district_id' => Request::input('district_id'),
        ]);

        return Redirect::route('establishments')->with('success', 'Establishment created.');
    }

    public function edit(Establishment $establishment): Response
    {
        $departments = Department::all(['id', 'description']);
        $provinces = Province::all(['id', 'description', 'department_id']);
        $districts = District::all(['id', 'description', 'province_id']);

        return Inertia::render('Establishments/Edit', [
            'establishment' => [
                'id' => $establishment->id,
                'description' => $establishment->description,
                'address' => $establishment->address,
                'email' => $establishment->email,
                'phone' => $establishment->phone,
                'code' => $establishment->code,
                'company_id' => $establishment->company_id,
                'department_id' => $establishment->department_id,
                'province_id' => $establishment->province_id,
                'district_id' => $establishment->district_id,
                'deleted_at' => $establishment->deleted_at,
            ],

            'companies' => Auth::user()->account->companies()
                ->orderBy('name')
                ->withTrashed()
                ->get()
                ->map
                ->only('id', 'name'),

            'departments' => $departments,
            'provinces' => $provinces,
            'districts' => $districts,
        ]);
    }

    public function update(Establishment $establishment): RedirectResponse
    {
        Request::validate([
            'description' => ['required', 'max:150'],
            'address' => ['nullable', 'max:150'],
            'email' => ['nullable', 'max:50', 'email'],
            'phone' => ['nullable', 'max:50'],
            'code' => ['required', 'max:4'],
            'company_id' => ['required', 'exists:companies,id'],
            'department_id' => ['required', 'exists:departments,id'],
            'province_id' => ['required', 'exists:provinces,id'],
            'district_id' => ['required', 'exists:districts,id'],
        ]);

        $establishment->update([
            'description' => Request::input('description'),
            'address' => Request::input('address'),
            'email' => Request::input('email'),
            'phone' => Request::input('phone'),
            'code' => Request::input('code'),
            'company_id' => Request::input('company_id'),
            'department_id' => Request::input('department_id'),
            'province_id' => Request::input('province_id'),
            'district_id' => Request::input('district_id'),
        ]);

        return Redirect::back()->with('success', 'Establishment updated.');
    }

    public function destroy(Establishment $establishment): RedirectResponse
    {
        try {
            $establishment->delete();
            return Redirect::route('establishments')->with('success', 'Establishment deleted.');
        } catch (Throwable $e) {
            $errorCode = $e->getCode();
            if ($errorCode === '23000') {
                return Redirect::back()->with('error', 'Cannot delete establishment. There are associated quotations.');
            } else {
                return Redirect::back()->with('error', 'An error occurred while deleting the establishment.');
            }
        }
    }
    public function restore(Establishment $establishment): RedirectResponse
    {
        $establishment->restore();

        return Redirect::back()->with('success', 'Establishment restored.');
    }
}
