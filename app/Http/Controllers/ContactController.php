<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Service;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Show contact/booking page with branches and services from DB
     */
    public function index()
    {
        $branches = Branch::active()->orderBy('sort_order')->get();
        $services = Service::active()->orderBy('category_type')->orderBy('sort_order')->get();

        return view('contact', compact('branches', 'services'));
    }
}
