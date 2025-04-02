<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\URL;
use Inertia\Response;
use Inertia\Inertia;

// Models
use App\Models\Catalogs\Template;
use App\Models\Company;

class TemplateController extends Controller
{

    public function index(): Response
    {
        $companies = Company::all(['id', 'name', 'trade_name', 'template_id']);

        return Inertia::render('Templates/Edit', [
            'companies' => $companies,
            'templates' => Template::all()
                ->transform(fn($template) => [
                    'id' => $template->id,
                    'description' => $template->description,
                    'photo' => $template->photo_path ? URL::route('image', ['path' => $template->photo_path, 'w' => 200,]) : null,
                ]),
        ]);
    }


    public function update(Company $company): RedirectResponse
    {
        Request::validate([
            'template_id' => ['required', 'exists:templates,id'],
        ]);

        $company->update(Request::only(['template_id']));

        return Redirect::back()->with('success', 'Template updated.');
    }
}
