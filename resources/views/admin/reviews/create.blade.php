@extends('layouts.admin')

@section('content')
<h1 class="text-3xl font-bold text-[#173C32] mb-6">Create Admin Review</h1>

<form action="{{ route('admin.reviews.store') }}" method="POST" class="bg-white p-8 shadow-sm max-w-xl space-y-4">
    @csrf
    <div>
        <label class="block text-xs font-bold uppercase mb-1">Reviewer Name *</label>
        <input type="text" name="reviewer_name" value="{{ old('reviewer_name') }}" required class="w-full border-gray-300">
    </div>

    <div>
        <label class="block text-xs font-bold uppercase mb-1">Reviewer Title / Source</label>
        <input type="text" name="reviewer_title" value="{{ old('reviewer_title') }}" placeholder="e.g., Manhattan Dining Guide • Verified Diner" class="w-full border-gray-300">
    </div>

    <div>
        <label class="block text-xs font-bold uppercase mb-1">Star Rating (1 to 5) *</label>
        <select name="rating" class="w-full border-gray-300">
            <option value="5">★★★★★ (5 Stars)</option>
            <option value="4">★★★★☆ (4 Stars)</option>
            <option value="3">★★★☆☆ (3 Stars)</option>
            <option value="2">★★☆☆☆ (2 Stars)</option>
            <option value="1">★☆☆☆☆ (1 Star)</option>
        </select>
    </div>

    <div>
        <label class="block text-xs font-bold uppercase mb-1">Review Text *</label>
        <textarea name="review_text" rows="4" required class="w-full border-gray-300">{{ old('review_text') }}</textarea>
    </div>

    <label class="inline-flex items-center gap-2 text-sm">
        <input type="checkbox" name="is_published" value="1" checked> Publish on Website
    </label>

    <div class="pt-2">
        <button type="submit" class="bg-[#173C32] text-[#C6A15B] px-6 py-3 text-xs uppercase font-bold tracking-widest">
            Save Review
        </button>
    </div>
</form>
@endsection