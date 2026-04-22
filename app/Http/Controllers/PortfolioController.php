<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Models\PortfolioCategory;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    public function index(Request $request)
    {
        $portfolioCategories = PortfolioCategory::where('is_active', true)
            ->with(['portfolios' => function ($query) {
                $query->with('category')
                    ->orderBy('sort_order')
                    ->orderByDesc('is_featured')
                    ->orderByDesc('created_at');
            }])
            ->withCount('portfolios')
            ->having('portfolios_count', '>', 0)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get()
            ->filter(fn($c) => $c->portfolios->isNotEmpty())
            ->values();

        return view('portfolio.index', compact('portfolioCategories'));
    }

    public function show(Portfolio $portfolio)
    {
        $relatedProjects = Portfolio::with('category.parent')
            ->where('portfolio_category_id', $portfolio->portfolio_category_id)
            ->where('id', '!=', $portfolio->id)
            ->orderBy('sort_order')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        $portfolio->load('videos');

        return view('portfolio.show', compact('portfolio', 'relatedProjects'));
    }
}
