<?php

namespace App\Http\Controllers;

use App\Models\Establishment;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Request;
use App\Http\Services\ExchangeRate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Inertia\Inertia;
use Inertia\Response;
// Models
use App\Models\Quotation;
use App\Models\Company;
use App\Models\Person;


class QuotationsController extends Controller
{
    protected $exchangeRateService;

    public function __construct(ExchangeRate $exchangeRateService)
    {
        $this->exchangeRateService = $exchangeRateService;
    }

    public function index(): Response
    {
        $companies = Company::all(['id', 'name']);

        return Inertia::render('Quotations/Index', [
            'companies' => $companies,
            'filters' => Request::all(['search', 'date_start', 'date_end', 'company_search', 'customer_search']),
            'quotations' => Quotation::with([
                'company' => function ($query) {
                    $query->withTrashed();
                },
                'person' => function ($query) {
                    $query->withTrashed();
                }
            ])
                ->orderByDateOfIssueDesc()
                ->filter(Request::only(['search', 'date_start', 'date_end', 'company_search', 'customer_search']))
                ->paginate(10)
                ->withQueryString()
                ->through(function ($quotation) {
                    return [
                        'id' => $quotation->id,
                        'date_of_issue' => $quotation->date_of_issue->format('d-m-Y'),
                        'customer' => $quotation->person->name,
                        'state_type_id' => $quotation->state_type_id,
                        'prefix' => $quotation->identifier,
                        'currency_type_id' => $quotation->currency_type_id,
                        'subtotal' => $quotation->subtotal,
                        'total_igv' => $quotation->total_igv,
                        'total' => $quotation->total,
                        'filename' => $quotation->filename,
                        'company' => $quotation->company->name,
                        'deleted_at_company' => $quotation->company->deleted_at,
                        'deleted_at_person' => $quotation->person->deleted_at
                    ];
                }),
        ]);
    }
    public function create($companyId): Response
    {
        $company = Company::with([
            'department:id,description',
            'province:id,description',
            'district:id,description',
            'establishments:id,description,company_id'
        ])->find($companyId);

        $persons = Person::all(['id', 'name']);
        $exchangeRate = $this->exchangeRateService->searchDate(now()->format('Y-m-d'));

        return Inertia::render('Quotations/Create', [
            'company' => $company,
            'persons' => $persons,
            'exchangeRate' => $exchangeRate,
            'logo' => $company->logo_path ? URL::route('image', ['path' => $company->logo_path, 'w' => 130]) : null,
        ]);
    }

    public function store(): RedirectResponse
    {
        $data = Request::validate([
            'date_of_issue' => 'required|date',
            'date_of_due' => 'required|date',
            'delivery_date' => 'required|date',
            'customer_id' => 'required|integer',
            'establishment_id' => 'required|integer',
            'currency_type_id' => 'required|string',
            'payment_method_type_id' => 'required|string',
            'exchange_rate_sale' => 'required|numeric',
            'items' => 'required|array',
            'items.*.name' => 'required',
            'items.*.description' => 'nullable|string',
            'items.*.quantity' => 'required|numeric',
            'items.*.unit_value' => 'required|numeric',
            'items.*.unit_price' => 'required|numeric',
            'items.*.unit_type_id' => 'required|string',
            'items.*.affectation_igv_type_id' => 'required',
            'items.*.includes_igv' => 'nullable|boolean',
            'items.*.charge' => 'nullable|numeric',
            'items.*.discount' => 'nullable|numeric',
            'items.*.igv' => 'required|numeric',
            'items.*.subtotal' => 'nullable|numeric',
            'items.*.total' => 'required|numeric',
            'total_charge' => 'nullable|numeric',
            'total_discount' => 'nullable|numeric',
            'subtotal' => 'required|numeric',
            'total' => 'required|numeric',
            'total_igv' => 'required|numeric',
        ]);

        DB::transaction(function () use ($data) {
            $quotation = Quotation::create([
                'user_id' => auth()->id(),
                'external_id' => uniqid(),
                'establishment_id' => $data['establishment_id'],
                'state_type_id' => '01',
                'prefix' => 'COT',
                'date_of_issue' => $data['date_of_issue'],
                'date_of_due' => $data['date_of_due'],
                'delivery_date' => $data['delivery_date'],
                'customer_id' => $data['customer_id'],
                'currency_type_id' => $data['currency_type_id'],
                'payment_method_type_id' => $data['payment_method_type_id'],
                'exchange_rate_sale' => $data['exchange_rate_sale'],
                'total_charge' => $data['total_charge'],
                'total_discount' => $data['total_discount'],
                'total_igv' => $data['total_igv'],
                'subtotal' => $data['subtotal'],
                'total' => $data['total'],
                'filename' => 'quotation_' . uniqid() . '.pdf',
            ]);

            foreach ($data['items'] as $item) {
                $quotation->items()->create([
                    'name' => $item['name'],
                    'description' => $item['description'],
                    'unit_type_id' => $item['unit_type_id'],
                    'affectation_igv_type_id' => $item['affectation_igv_type_id'],
                    'includes_igv' => $item['includes_igv'],
                    'quantity' => $item['quantity'],
                    'unit_value' => $item['unit_value'],
                    'unit_price' => $item['unit_price'],
                    'charge' => $item['charge'],
                    'discount' => $item['discount'],
                    'igv' => $item['igv'],
                    'subtotal' => $item['subtotal'],
                    'total' => $item['total'],
                ]);
            }
        });

        return Redirect::route('quotations')->with('success', 'Quotation created.');
    }

    public function edit(Quotation $quotation): Response
    {
        $company = Company::withTrashed()->with([
            'department:id,description',
            'province:id,description',
            'district:id,description',
            'establishments:id,description,company_id'
        ])
            ->find($quotation->establishment->company_id);

        $persons = Person::withTrashed()->get(['id', 'name']);
        $quotationItems = $quotation->items()->get();

        return Inertia::render('Quotations/Edit', [
            'persons' => $persons,
            'quotation' => [
                'id' => $quotation->id,
                'date_of_issue' => $quotation->date_of_issue->format('Y-m-d'),
                'date_of_due' => $quotation->date_of_due->format('Y-m-d'),
                'delivery_date' => $quotation->delivery_date->format('Y-m-d'),
                'customer_id' => $quotation->customer_id,
                'establishment_id' => $quotation->establishment_id,
                'currency_type_id' => $quotation->currency_type_id,
                'payment_method_type_id' => $quotation->payment_method_type_id,
                'exchange_rate_sale' => $quotation->exchange_rate_sale,
                'total_charge' => $quotation->total_charge,
                'total_discount' => $quotation->total_discount,
                'total_igv' => $quotation->total_igv,
                'subtotal' => $quotation->subtotal,
                'total' => $quotation->total,
                'filename' => $quotation->filename,
                'items' => $quotationItems,
            ],
            'company' => [
                'id' => $company->id,
                'name' => $company->name,
                'trade_name' => $company->trade_name,
                'number' => $company->number,
                'department_id' => $company->department_id,
                'department_description' => $company->department->description,
                'province_id' => $company->province_id,
                'province_description' => $company->province->description,
                'district_id' => $company->district_id,
                'district_description' => $company->district->description,
                'address' => $company->address,
                'email' => $company->email,
                'phone' => $company->phone,
                'logo' => $company->logo_path ? URL::route('image', ['path' => $company->logo_path, 'w' => 130]) : null,
                'establishments' => $company->establishments
            ],
        ]);
    }

    public function update(Quotation $quotation): RedirectResponse
    {
        $data = Request::validate([
            'date_of_issue' => 'required|date',
            'date_of_due' => 'required|date',
            'delivery_date' => 'required|date',
            'customer_id' => 'required|integer',
            'establishment_id' => 'required|integer',
            'currency_type_id' => 'required|string',
            'payment_method_type_id' => 'required|string',
            'exchange_rate_sale' => 'required|numeric',
            'items' => 'required|array',
            'items.*.name' => 'required',
            'items.*.description' => 'nullable|string',
            'items.*.quantity' => 'required|numeric',
            'items.*.unit_value' => 'required|numeric',
            'items.*.unit_price' => 'required|numeric',
            'items.*.unit_type_id' => 'required|string',
            'items.*.affectation_igv_type_id' => 'required',
            'items.*.includes_igv' => 'nullable|boolean',
            'items.*.charge' => 'nullable|numeric',
            'items.*.discount' => 'nullable|numeric',
            'items.*.igv' => 'required|numeric',
            'items.*.subtotal' => 'nullable|numeric',
            'items.*.total' => 'required|numeric',
            'total_charge' => 'nullable|numeric',
            'total_discount' => 'nullable|numeric',
            'subtotal' => 'required|numeric',
            'total' => 'required|numeric',
            'total_igv' => 'required|numeric',
        ]);

        DB::transaction(function () use ($data, $quotation) {
            $quotation->update([
                'establishment_id' => $data['establishment_id'],
                'date_of_issue' => $data['date_of_issue'],
                'date_of_due' => $data['date_of_due'],
                'delivery_date' => $data['delivery_date'],
                'customer_id' => $data['customer_id'],
                'currency_type_id' => $data['currency_type_id'],
                'payment_method_type_id' => $data['payment_method_type_id'],
                'exchange_rate_sale' => $data['exchange_rate_sale'],
                'total_charge' => $data['total_charge'],
                'total_discount' => $data['total_discount'],
                'total_igv' => $data['total_igv'],
                'subtotal' => $data['subtotal'],
                'total' => $data['total'],
            ]);

            $quotation->items()->delete();

            foreach ($data['items'] as $item) {
                $quotation->items()->create([
                    'name' => $item['name'],
                    'description' => $item['description'],
                    'unit_type_id' => $item['unit_type_id'],
                    'affectation_igv_type_id' => $item['affectation_igv_type_id'],
                    'includes_igv' => $item['includes_igv'],
                    'quantity' => $item['quantity'],
                    'unit_value' => $item['unit_value'],
                    'unit_price' => $item['unit_price'],
                    'charge' => $item['charge'],
                    'discount' => $item['discount'],
                    'igv' => $item['igv'],
                    'subtotal' => $item['subtotal'],
                    'total' => $item['total'],
                ]);
            }
        });

        return Redirect::route('quotations')->with('success', 'Quotation updated.');
    }

    public function exportToPDF($id)
    {
        $quotation = Quotation::with([
            'payment_method',
            'user',
            'items',
            'person' => function ($query) {
                $query->withTrashed();
            },
            'company' => function ($query) {
                $query->withTrashed();
            },
        ])
            ->findOrFail($id);

        // Check for deleted company (optional)
        if ($quotation->company->trashed()) {
            return Redirect::route('quotations')->with('error', 'Company has been deleted');
        }

        // Check for deleted person (optional)
        if ($quotation->person->trashed()) {
            return Redirect::route('quotations')->with('error', 'Person has been deleted');
        }

        // Company logo (handle missing logo path)
        // $logo = $quotation->company->logo_path ? URL::route('image', ['path' => $quotation->company->logo_path, 'w' => 200]) : null;

        $logoPath = $quotation->company->logo_path;
        $logo = $logoPath ? storage_path('app/' . $logoPath) : null;

        if ($logoPath) {
            $logo = base64_encode(file_get_contents($logo));
        }

        $template = $quotation->company->template_id ? 'quotations.template_' . $quotation->company->template_id : 'quotations.template_1';
        $pdf = PDF::loadView($template, compact('quotation', 'logo'));

        return $pdf->stream($quotation->filename);
        // Alternatively, use return $pdf->download($quotation->filename); for a downloadable PDF
    }
}
