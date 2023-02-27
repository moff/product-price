<?php

namespace Tests\Feature;

use App\Models\Price;
use App\Models\Product;
use App\Models\Variant;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\WebTestCase;

class SetProductPriceControllerTest extends WebTestCase
{
    use DatabaseTransactions;

    /**
     * @return void
     */
    public function test_set_product_price_endpoint(): void
    {
        /** @var Product $product */
        $product = Product::factory()->create();

        /** @var Variant $variant */
        $variant = Variant::factory()->create([
            'product_id' => $product->id,
        ]);

        $this->assertEquals(0, Price::count());

        $expectedCurrency = Price::CURRENCY_EUR;
        $expectedAmount = 100;

        $response = $this->post(route('set-product-price'), [
            'product_id' => $product->id,
            'variant_id' => $variant->id,
            'currency' => $expectedCurrency,
            'amount' => $expectedAmount,
        ]);

        $response->assertStatus(200);

        $this->assertEquals(1, Price::count());
        $this->assertEquals($expectedCurrency, $variant->price->currency);
        $this->assertEquals($expectedAmount, $variant->price->amount);
    }
}
