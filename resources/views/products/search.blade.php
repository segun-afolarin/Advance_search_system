@extends('layouts.app')

@section('content')
    @php
        $activeFilters = collect([
            request('q') ? 'Search: ' . request('q') : null,
            request('category_id') ? 'Category selected' : null,
            request('brand_id') ? 'Brand selected' : null,
            request('status') ? 'Status: ' . ucfirst(request('status')) : null,
            request('min_price') ? 'Min ₦' . request('min_price') : null,
            request('max_price') ? 'Max ₦' . request('max_price') : null,
        ])->filter()->values();
    @endphp

    <section class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-xl shadow-slate-200/60">
        <div class="grid gap-0 lg:grid-cols-[1.05fr_0.95fr]">
            <div class="relative overflow-hidden bg-red-600 px-6 py-10 text-white sm:px-8 lg:px-10">
                <div class="absolute -right-10 -top-10 h-40 w-40 rounded-full bg-white/10 blur-2xl"></div>
                <div class="absolute bottom-0 left-0 h-32 w-32 rounded-full bg-black/10 blur-2xl"></div>

                <span class="inline-flex items-center rounded-full border border-white/20 bg-white/10 px-4 py-1 text-xs font-bold uppercase tracking-[0.22em]">
                    Scout • Filters • Ranking • Pagination
                </span>

                <h2 class="mt-5 max-w-2xl text-4xl font-black leading-tight sm:text-5xl">
                    Search products with a premium red and white interface.
                </h2>

                <p class="mt-4 max-w-2xl text-sm leading-7 text-red-50 sm:text-base">
                    This Advanced Search System uses Laravel Scout with filtering, ranking, and pagination to deliver accurate and professional search results.
                </p>

                <div class="mt-8 flex flex-wrap gap-3">
                    <span class="rounded-full bg-white/15 px-4 py-2 text-xs font-semibold uppercase tracking-wider">Laravel Scout</span>
                    <span class="rounded-full bg-white/15 px-4 py-2 text-xs font-semibold uppercase tracking-wider">Premium UI</span>
                    <span class="rounded-full bg-white/15 px-4 py-2 text-xs font-semibold uppercase tracking-wider">Responsive</span>
                    <span class="rounded-full bg-white/15 px-4 py-2 text-xs font-semibold uppercase tracking-wider">Image Cards</span>
                </div>
            </div>

            <div class="bg-white px-6 py-8 sm:px-8 lg:px-10">
                <form method="GET" action="{{ route('products.search') }}" class="space-y-5">
                    <div>
                        <label for="q" class="mb-2 block text-sm font-bold text-slate-800">Search</label>
                        <input
                            id="q"
                            name="q"
                            type="text"
                            value="{{ request('q') }}"
                            placeholder="Search by product name, SKU, brand, category or description"
                            class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm outline-none transition focus:border-red-500 focus:ring-4 focus:ring-red-100"
                        >
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label class="mb-2 block text-sm font-bold text-slate-800">Category</label>
                            <select name="category_id" class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm outline-none transition focus:border-red-500 focus:ring-4 focus:ring-red-100">
                                <option value="">All categories</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @selected((string) request('category_id') === (string) $category->id)>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-bold text-slate-800">Brand</label>
                            <select name="brand_id" class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm outline-none transition focus:border-red-500 focus:ring-4 focus:ring-red-100">
                                <option value="">All brands</option>
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}" @selected((string) request('brand_id') === (string) $brand->id)>
                                        {{ $brand->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label class="mb-2 block text-sm font-bold text-slate-800">Status</label>
                            <select name="status" class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm outline-none transition focus:border-red-500 focus:ring-4 focus:ring-red-100">
                                <option value="">Active only</option>
                                <option value="active" @selected(request('status') === 'active')>Active</option>
                                <option value="draft" @selected(request('status') === 'draft')>Draft</option>
                                <option value="archived" @selected(request('status') === 'archived')>Archived</option>
                            </select>
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-bold text-slate-800">Sort by</label>
                            <select name="sort" class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm outline-none transition focus:border-red-500 focus:ring-4 focus:ring-red-100">
                                <option value="relevance" @selected(request('sort', 'relevance') === 'relevance')>Relevance</option>
                                <option value="price_asc" @selected(request('sort') === 'price_asc')>Price: Low to High</option>
                                <option value="price_desc" @selected(request('sort') === 'price_desc')>Price: High to Low</option>
                                <option value="newest" @selected(request('sort') === 'newest')>Newest</option>
                                <option value="oldest" @selected(request('sort') === 'oldest')>Oldest</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-3">
                        <div>
                            <label class="mb-2 block text-sm font-bold text-slate-800">Min price</label>
                            <input
                                type="number"
                                name="min_price"
                                step="0.01"
                                min="0"
                                value="{{ request('min_price') }}"
                                placeholder="0.00"
                                class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm outline-none transition focus:border-red-500 focus:ring-4 focus:ring-red-100"
                            >
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-bold text-slate-800">Max price</label>
                            <input
                                type="number"
                                name="max_price"
                                step="0.01"
                                min="0"
                                value="{{ request('max_price') }}"
                                placeholder="5000.00"
                                class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm outline-none transition focus:border-red-500 focus:ring-4 focus:ring-red-100"
                            >
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-bold text-slate-800">Per page</label>
                            <select name="per_page" class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm outline-none transition focus:border-red-500 focus:ring-4 focus:ring-red-100">
                                @foreach ([6, 12, 18, 24, 36, 48] as $size)
                                    <option value="{{ $size }}" @selected((int) request('per_page', 12) === $size)>
                                        {{ $size }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-3 pt-2">
                        <button
                            type="submit"
                            class="inline-flex items-center justify-center rounded-2xl bg-red-600 px-6 py-3 text-sm font-bold text-white shadow-lg shadow-red-200 transition hover:-translate-y-0.5 hover:bg-red-700">
                            Search
                        </button>

                        <a href="{{ route('products.search') }}"
                           class="inline-flex items-center justify-center rounded-2xl border border-slate-300 bg-white px-6 py-3 text-sm font-semibold text-slate-800 transition hover:bg-slate-50">
                            Clear Filters
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </section>

    @if ($activeFilters->isNotEmpty())
        <div class="mt-6 flex flex-wrap gap-2">
            @foreach ($activeFilters as $filter)
                <span class="rounded-full border border-red-200 bg-red-50 px-3 py-1 text-xs font-semibold text-red-700">
                    {{ $filter }}
                </span>
            @endforeach
        </div>
    @endif

    <section class="mt-8">
        <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h3 class="text-2xl font-black text-slate-900">Results</h3>
                <p class="mt-1 text-sm text-slate-600">
                    Showing
                    <span class="font-bold text-slate-900">{{ $products->firstItem() ?? 0 }}</span>
                    to
                    <span class="font-bold text-slate-900">{{ $products->lastItem() ?? 0 }}</span>
                    of
                    <span class="font-bold text-slate-900">{{ $products->total() }}</span>
                    results
                </p>
            </div>

            @if (filled(request('q')))
                <div class="rounded-2xl border border-red-100 bg-red-50 px-4 py-3 text-sm font-semibold text-red-700">
                    Ranked by relevance
                </div>
            @endif
        </div>

        @if ($products->count())
            <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                @foreach ($products as $product)
                    <article class="card-rise overflow-hidden rounded-[1.75rem] border border-slate-200 bg-white shadow-lg shadow-slate-200/50">
                        <div class="relative h-56 w-full overflow-hidden">
                            <img
                                src="{{ $product->image_url ? asset($product->image_url) : asset('images/products/default-product.jpg') }}"
                                alt="{{ $product->name }}"
                                class="h-full w-full object-cover transition duration-500 hover:scale-105"
                                onerror="this.onerror=null;this.src='{{ asset('images/products/default-product.jpg') }}';"
                            >

                            <div class="absolute left-4 top-4 flex flex-wrap gap-2">
                                @if ($product->is_featured)
                                    <span class="rounded-full bg-red-600 px-3 py-1 text-[11px] font-bold uppercase tracking-wider text-white">
                                        Featured
                                    </span>
                                @endif

                                <span class="rounded-full bg-white/90 px-3 py-1 text-[11px] font-bold uppercase tracking-wider text-slate-700 shadow">
                                    {{ ucfirst($product->status) }}
                                </span>
                            </div>
                        </div>

                        <div class="p-5">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <h4 class="text-xl font-black tracking-tight text-slate-900">
                                        {{ $product->name }}
                                    </h4>

                                    <p class="mt-1 text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">
                                        SKU: {{ $product->sku }}
                                    </p>
                                </div>

                                <div class="rounded-2xl bg-red-50 px-4 py-3 text-right">
                                    <p class="text-[11px] font-bold uppercase tracking-wider text-red-600">Price</p>
                                    <p class="mt-1 text-lg font-black text-red-700">₦{{ number_format((float) $product->price, 2) }}</p>
                                </div>
                            </div>

                            <p class="mt-4 text-sm leading-7 text-slate-600">
                                {{ \Illuminate\Support\Str::limit($product->description, 140) }}
                            </p>

                            <div class="mt-5 grid grid-cols-2 gap-3 text-sm">
                                <div class="rounded-2xl bg-slate-50 p-4">
                                    <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Category</p>
                                    <p class="mt-1 font-semibold text-slate-900">{{ $product->category->name }}</p>
                                </div>

                                <div class="rounded-2xl bg-slate-50 p-4">
                                    <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Brand</p>
                                    <p class="mt-1 font-semibold text-slate-900">{{ $product->brand->name }}</p>
                                </div>

                                <div class="rounded-2xl bg-slate-50 p-4">
                                    <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Stock</p>
                                    <p class="mt-1 font-semibold text-slate-900">{{ $product->stock }}</p>
                                </div>

                                <div class="rounded-2xl bg-slate-50 p-4">
                                    <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Added</p>
                                    <p class="mt-1 font-semibold text-slate-900">{{ $product->created_at->format('M d, Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $products->links() }}
            </div>
        @else
            <div class="rounded-[1.75rem] border border-dashed border-slate-300 bg-white p-12 text-center shadow-sm">
                <h3 class="text-2xl font-black text-slate-900">No products found</h3>
                <p class="mt-2 text-sm text-slate-600">
                    Try another keyword or widen your filters.
                </p>

                <div class="mt-5">
                    <a href="{{ route('products.search') }}"
                       class="inline-flex items-center rounded-2xl bg-red-600 px-6 py-3 text-sm font-bold text-white transition hover:bg-red-700">
                        Reset Search
                    </a>
                </div>
            </div>
        @endif
    </section>
@endsection