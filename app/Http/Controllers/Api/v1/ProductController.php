<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\RecommendationService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'brand', 'primaryImage', 'b2bPriceTiers'])
            ->where('status', 'active');

        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('sku', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'newest':
                default:
                    $query->orderBy('id', 'desc');
                    break;
            }
        } else {
            $query->orderBy('id', 'desc');
        }

        $products = $query->paginate($request->get('per_page', 12));

        return response()->json([
            'success' => true,
            'message' => 'Products retrieved successfully',
            'data' => $products,
        ]);
    }

    public function show($id, RecommendationService $recommendationService)
    {
        $product = Product::with(['category', 'brand', 'images', 'variants', 'b2bPriceTiers', 'reviews.user'])
            ->findOrFail($id);

        $product->increment('view_count');

        $bundle = $recommendationService->getBundleForProduct($product->id);
        $fomo = $recommendationService->getFOMOStats($product);

        return response()->json([
            'success' => true,
            'data' => [
                'product' => $product,
                'bundle' => $bundle,
                'fomo' => $fomo,
            ]
        ]);
    }

    public function featured()
    {
        $featured = Product::with(['primaryImage', 'category', 'b2bPriceTiers'])
            ->where('status', 'active')
            ->where('is_featured', true)
            ->take(8)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $featured,
        ]);
    }

    public function flashSales()
    {
        $flashSales = Product::with(['primaryImage', 'category'])
            ->where('status', 'active')
            ->where('is_flash_sale', true)
            ->take(6)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $flashSales,
        ]);
    }
}
