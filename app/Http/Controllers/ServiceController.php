<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Branch;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::active()
            ->orderBy('category_type')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        $groupedServices = $services->groupBy('category_type');

        $branches = Branch::active()->orderBy('sort_order')->get();

        $stats = [
            'total'      => $services->count(),
            'categories' => $groupedServices->keys(),
        ];

        return view('services', compact('services', 'groupedServices', 'branches', 'stats'));
    }
}


