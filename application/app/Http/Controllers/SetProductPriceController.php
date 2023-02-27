<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\SetProductPriceRequest;
use App\Models\Product;
use App\Service\PriceService;
use Exception;
use Illuminate\Http\JsonResponse;

class SetProductPriceController extends Controller
{
    /**
     * Handle the incoming request.
     * @param SetProductPriceRequest $request
     * @param PriceService $priceService
     * @return JsonResponse
     * @throws Exception
     */
    public function __invoke(
        SetProductPriceRequest $request,
        PriceService $priceService
    ): JsonResponse {
        $product = Product::findOrFail($request->get('product_id'));
        $variant = $product->variants->where('id', $request->get('variant_id'))->first();
        $currency = $request->get('currency');
        $amount = $request->get('amount');

        $priceService->setProductPrice($product, $variant, $currency, $amount);

        return response()->json();
    }
}
