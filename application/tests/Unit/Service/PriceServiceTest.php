<?php

declare(strict_types=1);

namespace Tests\Unit\Service;

use App\Models\Price;
use App\Models\Product;
use App\Models\Variant;
use App\Service\PriceService;
use Exception;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\WebTestCase;

class PriceServiceTest extends WebTestCase
{
    use DatabaseTransactions;

    /**
     * @return void
     */
    public function test_set_price_for_variant_method()
    {
        /** @var PriceService $service */
        $service = resolve(PriceService::class);

        /** @var Variant $variant */
        $variant = Variant::factory()->create();
        $this->assertFalse($variant->price()->exists());

        $expectedCurrency = Price::CURRENCY_EUR;
        $expectedAmount = 100;

        $this->assertEquals(0, Price::count());

        $service->setPriceForVariant($variant, $expectedCurrency, $expectedAmount);

        $this->assertTrue($variant->price()->exists());
        $this->assertEquals(1, Price::count());

        $price = Price::first();
        $this->assertEquals($expectedCurrency, $price->currency);
        $this->assertEquals($expectedAmount, $price->amount);
        $this->assertEquals($variant->product_id, $price->product_id);

        $expectedCurrency = Price::CURRENCY_USD;
        $expectedAmount = 200;

        $service->setPriceForVariant($variant, $expectedCurrency, $expectedAmount);

        $this->assertTrue($variant->price()->exists());
        $this->assertEquals(1, Price::count());

        $price = Price::first();
        $this->assertEquals($expectedCurrency, $price->currency);
        $this->assertEquals($expectedAmount, $price->amount);
        $this->assertEquals($variant->product_id, $price->product_id);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function test_set_same_price_for_all_variants_method()
    {
        /** @var Product $product */
        $product = Product::factory()->create([
            'variant_pricing' => Product::VARIANT_PRICING_SAME_FOR_ALL,
        ]);

        /** @var Variant $variant1 */
        $variant1 = Variant::factory()->create([
            'product_id' => $product->id,
        ]);

        /** @var Variant $variant2 */
        $variant2 = Variant::factory()->create([
            'product_id' => $product->id,
        ]);

        $this->assertEquals(0, Price::count());

        /** @var PriceService $service */
        $service = resolve(PriceService::class);

        $expectedCurrency = Price::CURRENCY_USD;
        $expectedAmount = 200;

        $service->setSamePriceForAllVariants($product, $expectedCurrency, $expectedAmount);

        $this->assertEquals(2, Price::count());

        foreach (Price::all() as $price) {
            $this->assertEquals($expectedCurrency, $price->currency);
            $this->assertEquals($expectedAmount, $price->amount);
        }
    }

    /**
     * @return void
     * @throws Exception
     */
    public function test_set_product_price_for_individual_pricing()
    {
        /** @var Product $product */
        $product = Product::factory()->create([
            'variant_pricing' => Product::VARIANT_PRICING_INDIVIDUAL,
        ]);

        /** @var Variant $variant */
        $variant = Variant::factory()->create([
            'product_id' => $product->id,
        ]);

        $expectedCurrency = Price::CURRENCY_USD;
        $expectedAmount = 200;

        $priceServiceMock = $this->mock(PriceService::class)->makePartial();
        $priceServiceMock
            ->shouldReceive('setPriceForVariant')
            ->once();

        /** @var PriceService $service */
        $service = resolve(PriceService::class);

        $service->setProductPrice($product, $variant, $expectedCurrency, $expectedAmount);
    }
}
