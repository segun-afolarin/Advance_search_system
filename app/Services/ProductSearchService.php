<?php

namespace App\Services;

use App\Http\Requests\ProductSearchRequest;
use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class ProductSearchService
{
    public function search(ProductSearchRequest $request): LengthAwarePaginator
    {
        $term = trim((string) $request->input('q', ''));
        $perPage = (int) $request->input('per_page', 12);
        $sort = (string) $request->input('sort', 'relevance');

        if ($term !== '') {
            $search = Product::search($term)
                ->where(
                    'status',
                    '=',
                    $request->filled('status') ? $request->input('status') : 'active'
                )
                ->when($request->filled('category_id'), fn ($search) =>
                    $search->where('category_id', '=', (int) $request->input('category_id'))
                )
                ->when($request->filled('brand_id'), fn ($search) =>
                    $search->where('brand_id', '=', (int) $request->input('brand_id'))
                )
                ->when($request->filled('min_price'), fn ($search) =>
                    $search->where('price', '>=', (float) $request->input('min_price'))
                )
                ->when($request->filled('max_price'), fn ($search) =>
                    $search->where('price', '<=', (float) $request->input('max_price'))
                )
                ->query(function (Builder $query) use ($sort) {
                    $query->with([
                        'category:id,name,slug',
                        'brand:id,name,slug',
                    ]);

                    $this->applySortForSearchResults($query, $sort);
                });

            return $search->paginate($perPage)->withQueryString();
        }

        $query = Product::query()
            ->with([
                'category:id,name,slug',
                'brand:id,name,slug',
            ])
            ->where(
                'status',
                $request->filled('status') ? $request->input('status') : 'active'
            )
            ->when($request->filled('category_id'), fn (Builder $builder) =>
                $builder->where('category_id', (int) $request->input('category_id'))
            )
            ->when($request->filled('brand_id'), fn (Builder $builder) =>
                $builder->where('brand_id', (int) $request->input('brand_id'))
            )
            ->when($request->filled('min_price'), fn (Builder $builder) =>
                $builder->where('price', '>=', (float) $request->input('min_price'))
            )
            ->when($request->filled('max_price'), fn (Builder $builder) =>
                $builder->where('price', '<=', (float) $request->input('max_price'))
            );

        $this->applyDefaultSort($query, $sort);

        return $query->paginate($perPage)->withQueryString();
    }

    protected function applySortForSearchResults(Builder $query, string $sort): void
    {
        match ($sort) {
            'price_asc' => $query->orderBy('price'),
            'price_desc' => $query->orderByDesc('price'),
            'newest' => $query->orderByDesc('created_at'),
            'oldest' => $query->orderBy('created_at'),
            default => null,
        };
    }

    protected function applyDefaultSort(Builder $query, string $sort): void
    {
        match ($sort) {
            'price_asc' => $query->orderBy('price'),
            'price_desc' => $query->orderByDesc('price'),
            'newest' => $query->orderByDesc('created_at'),
            'oldest' => $query->orderBy('created_at'),
            default => $query->orderByDesc('is_featured')->orderByDesc('created_at'),
        };
    }
}