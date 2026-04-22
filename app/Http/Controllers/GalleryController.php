<?php

namespace App\Http\Controllers;

use App\Models\GalleryImage;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        // Fetch all active images
        $query = GalleryImage::active();

        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }

        $images     = $query->get();
        $categories = GalleryImage::categories(); // ['Hair' => 'شعر', ...]

        // Before/After section images
        $beforeAfter = GalleryImage::active()->beforeAfter()->get();

        return view('gallery', compact('images', 'categories', 'beforeAfter'));
    }
}
