<?php

namespace App\Http\Controllers;

use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        return view('services.index', [
            'services' => Service::orderBy('sort_order')->get(),
        ]);
    }

    public function show(Service $service)
    {
        $service->load('packages', 'faqs');

        return view('services.show', [
            'service' => $service,
            'related' => Service::where('id', '!=', $service->id)->orderBy('sort_order')->take(3)->get(),
        ]);
    }
}
