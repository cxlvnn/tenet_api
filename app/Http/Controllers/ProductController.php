<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ProductController extends Controller
{
    public function index()
    {
        $products = Auth::user()->company->products()->paginate(5);

        return ProductResource::collection($products);
    }

    public function store(StoreProductRequest $request)
    {
        $user = Auth::user();
        $company = $user->company;
        $product = $company->products()->create($request->validated());

        return new ProductResource($product);
    }

    public function show(Product $product)
    {
        Gate::authorize('viewOrModify', $product);

        return new ProductResource($product);
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        Gate::authorize('viewOrModify', $product);
        $product->update($request->validated());

        return new ProductResource($product);
    }

    public function destroy(Product $product)
    {
        Gate::authorize('viewOrModify', $product);
        $product->delete();

        return response()->noContent();
    }
}
