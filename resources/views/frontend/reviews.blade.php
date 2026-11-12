@extends('layouts.app')
@section('title', 'Guest & Press Reviews')

@section('content')
<!-- Hero Section -->
<section class="bg-forest text-white py-12 sm:py-16 text-center px-4 sm:px-6">
    <span class="text-[#C6A15B] uppercase tracking-[0.2em] sm:tracking-[0.3em] text-xs font-bold">Critical Acclaim</span>
    <h1 class="font-serif-luxury text-3xl sm:text-4xl md:text-5xl font-bold mt-2 px-2">Verified Dining Reviews</h1>
</section>

<!-- Reviews Container -->
<div class="max-w-6xl mx-auto px-4 sm:px-6 py-10 sm:py-16">
    <!-- Reviews Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 sm:gap-8">
        @foreach($reviews as $review)
        <div class="bg-white p-6 sm:p-8 border border-[#173C32]/10 shadow-sm flex flex-col justify-between">
            <div>
                <!-- Star Rating -->
                <div class="text-[#C6A15B] text-lg sm:text-xl mb-3">{{ str_repeat('★', $review->rating) }}</div>
                <!-- Review Text -->
                <p class="font-serif-luxury italic text-xl sm:text-2xl text-forest mb-6 leading-relaxed">"{{ $review->review_text }}"</p>
            </div>
            <!-- Reviewer Info -->
            <div class="border-t pt-4">
                <p class="font-bold text-sm text-[#242A26]">{{ $review->reviewer_name }}</p>
                @if($review->reviewer_title)
                    <p class="text-xs text-gray-500 mt-0.5">{{ $review->reviewer_title }}</p>
                @endif
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination Links Wrapper -->
    <div class="mt-8 sm:mt-12 overflow-x-auto py-2">
        {{ $reviews->links() }}
    </div>
</div>
@endsection