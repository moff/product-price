<?php

declare(strict_types=1);

namespace App\Service;

use App\Models\Product;
use App\Models\Variant;
use Exception;
use Illuminate\Support\Facades\DB;

class PriceService
{
    /**
     * @param Product $product
     * @param Variant $variant
     * @param string $currency
     * @param int $amount
     * @throws Exception
     */
    public function setProductPrice(
        Product $product,
        Variant $variant,
        string $currency,
        int $amount
    ) {
        switch ($product->variant_pricing) {
            case Product::VARIANT_PRICING_INDIVIDUAL:
                $this->setPriceForVariant($variant, $currency, $amount);
                break;
            case Product::VARIANT_PRICING_SAME_FOR_ALL:
                $this->setSamePriceForAllVariants($product, $currency, $amount);
                break;
            default:
                throw new Exception('Variant pricing of product is invalid');
        }
    }

    /**
     * @param Product $product
     * @param string $currency
     * @param int $amount
     * @throws Exception
     */
    public function setSamePriceForAllVariants(
        Product $product,
        string $currency,
        int $amount
    ) {
        try {
            DB::beginTransaction();

            foreach ($product->variants as $variant) {
                $this->setPriceForVariant($variant, $currency, $amount);
            }
        } catch (Exception $e) {
            DB::rollBack();

            throw new Exception(
                'Failed to update prices for all variants of product',
                0,
                $e
            );
        }

        DB::commit();
    }

    /**
     * @param Variant $variant
     * @param string $currency
     * @param int $amount
     */
    public function setPriceForVariant(
        Variant $variant,
        string $currency,
        int $amount
    ) {
        $priceData = [
            'currency' => $currency,
            'amount' => $amount,
            'product_id' => $variant->product_id,
        ];

        if ($variant->price()->exists()) {
            $variant->price()->update($priceData);
        } else {
            $variant->price()->create($priceData);
        }
    }
}
