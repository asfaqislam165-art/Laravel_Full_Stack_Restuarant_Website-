<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\MenuItem;
use App\Models\Review;
use App\Models\SpecialOffer;

class HomeController extends Controller
{
    public function index()
    {
        $featuredItems = MenuItem::where('is_featured', true)->where('is_available', true)->take(6)->get();
        $popularItems = MenuItem::where('is_popular', true)->where('is_available', true)->take(4)->get();
        $offers = SpecialOffer::currentlyValid()->take(3)->get();
        $reviews = Review::where('is_published', true)->latest()->take(6)->get();

        return view('frontend.home', compact('featuredItems', 'popularItems', 'offers', 'reviews'));
    }

    public function about()
    {
        return view('frontend.about');
    }

    public function offers()
    {
        $offers = SpecialOffer::currentlyValid()->latest()->get();
        return view('frontend.offers', compact('offers'));
    }

    public function reviews()
    {
        $reviews = Review::where('is_published', true)->latest()->paginate(12);
        return view('frontend.reviews', compact('reviews'));
    }
}