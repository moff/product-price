<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\Product;
use App\Models\Variant;
use App\Models\VariantAttribute;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Jewelry category and add one product and 2 variants (length), with individual pricing
        $jewelryCategory = Category::factory()->create([
            'variant_pricing_default' => Category::VARIANT_PRICING_INDIVIDUAL,
            'name' => 'Jewelry',
        ]);

        $chain = Product::factory()->create([
            'name' => 'Golden Chain',
            'category_id' => $jewelryCategory->id,
            'variant_pricing' => Category::VARIANT_PRICING_INDIVIDUAL,
        ]);

        $chainVariantShort = Variant::factory()->create([
            'product_id' => $chain->id,
        ]);

        $lengthAttribute = Attribute::factory()->create([
            'name' => 'Length',
        ]);

        VariantAttribute::factory()->create([
            'variant_id' => $chainVariantShort->id,
            'attribute_id' => $lengthAttribute->id,
            'value' => '40cm',
        ]);

        $chainVariantLong = Variant::factory()->create([
            'product_id' => $chain->id,
        ]);

        VariantAttribute::factory()->create([
            'variant_id' => $chainVariantLong->id,
            'attribute_id' => $lengthAttribute->id,
            'value' => '60cm',
        ]);

        // Create Shoes category with one product of 2 variants (sizes), with same pricing
        $shoesCategory = Category::factory()->create([
            'variant_pricing_default' => Category::VARIANT_PRICING_SAME_FOR_ALL,
            'name' => 'Shoes',
        ]);

        $nikeAirShoes = Product::factory()->create([
            'name' => 'Nike Air',
            'category_id' => $shoesCategory->id,
            'variant_pricing' => Category::VARIANT_PRICING_SAME_FOR_ALL,
        ]);

        $nikeAirShoes42 = Variant::factory()->create([
            'product_id' => $nikeAirShoes->id,
        ]);

        $sizeAttribute = Attribute::factory()->create([
            'name' => 'Size',
        ]);

        VariantAttribute::factory()->create([
            'variant_id' => $nikeAirShoes42->id,
            'attribute_id' => $sizeAttribute->id,
            'value' => '42',
        ]);

        $nikeAirShoes44 = Variant::factory()->create([
            'product_id' => $nikeAirShoes->id,
        ]);

        VariantAttribute::factory()->create([
            'variant_id' => $nikeAirShoes44->id,
            'attribute_id' => $sizeAttribute->id,
            'value' => '44',
        ]);
    }
}
