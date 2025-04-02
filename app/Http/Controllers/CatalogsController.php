<?php

namespace App\Http\Controllers;

use App\Models\Catalogs\Template;
use App\Models\Catalogs\UnitType;
use App\Models\Catalogs\AffectationIgvType;
use App\Models\Catalogs\SystemIscType;
use App\Models\Catalogs\PriceType;
use App\Models\Catalogs\IdentityDocumentType;
use App\Models\Catalogs\PaymentMethodType;

class CatalogsController extends Controller
{
    public function getTemplates()
    {
        $templates = Template::all();
        return response()->json($templates);
    }

    public function getUnitTypes()
    {
        $unit_types = UnitType::all();
        return response()->json($unit_types);
    }

    public function getAffectationIgvTypes()
    {
        $affectation_igv_types = AffectationIgvType::all();
        return response()->json($affectation_igv_types);
    }

    public function getSystemIscTypes()
    {
        $system_isc_types = SystemIscType::all();
        return response()->json($system_isc_types);
    }

    public function getPriceTypes()
    {
        $price_types = PriceType::all();
        return response()->json($price_types);
    }

    public function getIdentityDocumentTypes()
    {
        $identity_document_types = IdentityDocumentType::all();
        return response()->json($identity_document_types);
    }

    public function getPaymentMethodTypes()
    {
        $payment_method_types = PaymentMethodType::all(['id', 'description']);
        return response()->json($payment_method_types);
    }



}
