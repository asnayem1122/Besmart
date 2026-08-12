<?php

namespace Database\Seeders;

use App\Models\B2BPriceTier;
use App\Models\Brand;
use App\Models\Business;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\FlashSale;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\ProductBundle;
use App\Models\ProductBundleItem;
use App\Models\ProductImage;
use App\Models\Review;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Core Users
        $admin = User::create([
            'name' => 'Besmart Master Admin',
            'email' => 'admin@besmart.com',
            'phone' => '+8801700000001',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'status' => 'active',
        ]);

        $b2bUser = User::create([
            'name' => 'Rahim Chowdhury (TechMart B2B)',
            'email' => 'b2b@techmart.com',
            'phone' => '+8801800000002',
            'password' => Hash::make('password'),
            'role' => 'b2b',
            'status' => 'active',
        ]);

        Business::create([
            'user_id' => $b2bUser->id,
            'company_name' => 'TechMart Electronics Ltd',
            'trade_license' => 'TL-8849201-BD',
            'vat_number' => 'VAT-9920194',
            'business_type' => 'Retail Chain & Distributor',
            'address' => 'Plot 14, Block C, Uttara Commercial Area, Dhaka',
            'city' => 'Dhaka',
            'country' => 'Bangladesh',
            'status' => 'approved',
            'credit_limit' => 500000.00,
        ]);

        $b2cUser = User::create([
            'name' => 'Anisur Rahman',
            'email' => 'customer@gmail.com',
            'phone' => '+8801900000003',
            'password' => Hash::make('password'),
            'role' => 'b2c',
            'status' => 'active',
        ]);

        // 2. Create Categories & Brands
        $cats = [
            'Electronics' => ['Mobile & Tablets', 'Audio & Headphones', 'Cameras & Drones'],
            'Computers & Laptops' => ['Gaming Laptops', 'UltraBooks', 'PC Components', 'Monitors'],
            'Accessories' => ['Gaming Mice & Keyboards', 'Power Banks & Chargers', 'Cables & Adapters'],
            'Smart Home' => ['Smart Lighting', 'Security Cameras', 'Robotic Vacuums'],
        ];

        $categoryModels = [];
        foreach ($cats as $parentName => $children) {
            $parent = Category::create([
                'name' => $parentName,
                'slug' => Str::slug($parentName),
                'description' => "Premium {$parentName} products with wholesale pricing.",
                'image_url' => 'https://images.unsplash.com/photo-1526738549149-8e07eca6c147?w=600&q=80',
            ]);
            $categoryModels[] = $parent;

            foreach ($children as $childName) {
                $categoryModels[] = Category::create([
                    'name' => $childName,
                    'slug' => Str::slug($childName),
                    'parent_id' => $parent->id,
                    'description' => "Top quality {$childName} items.",
                    'image_url' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=600&q=80',
                ]);
            }
        }

        $brands = ['ProGear', 'NexusTech', 'AeroPulse', 'Vanguard', 'OmniSound'];
        $brandModels = [];
        foreach ($brands as $bName) {
            $brandModels[] = Brand::create([
                'name' => $bName,
                'slug' => Str::slug($bName),
                'logo_url' => 'https://images.unsplash.com/photo-1599305445671-ac291c95aaa9?w=200&q=80',
            ]);
        }

        // 3. Products & Volume Tiers
        $productsData = [
            [
                'name' => 'ProGear Stealth X Pro Gaming Laptop 16"',
                'price' => 145000.00,
                'b2b_price' => 125000.00,
                'sale_price' => 139900.00,
                'stock' => 35,
                'moq' => 2,
                'weight' => 2.4,
                'category_id' => $categoryModels[4]->id, // Gaming Laptops
                'brand_id' => $brandModels[0]->id,
                'is_featured' => true,
                'is_flash_sale' => true,
                'image' => 'https://images.unsplash.com/photo-1603302576837-37561b2e2302?w=800&q=80',
                'tags' => ['gaming', 'rtx4080', 'intel-i9', '16-inch'],
            ],
            [
                'name' => 'OmniSound ANC Wireless Headphones Pro',
                'price' => 12500.00,
                'b2b_price' => 9500.00,
                'sale_price' => 10900.00,
                'stock' => 120,
                'moq' => 5,
                'weight' => 0.35,
                'category_id' => $categoryModels[2]->id, // Audio
                'brand_id' => $brandModels[4]->id,
                'is_featured' => true,
                'is_flash_sale' => false,
                'image' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=800&q=80',
                'tags' => ['anc', 'wireless', 'bluetooth', 'audio'],
            ],
            [
                'name' => 'NexusTech Ergonomic Wireless RGB Mouse',
                'price' => 2800.00,
                'b2b_price' => 1950.00,
                'sale_price' => 2400.00,
                'stock' => 250,
                'moq' => 10,
                'weight' => 0.12,
                'category_id' => $categoryModels[8]->id, // Gaming Mice
                'brand_id' => $brandModels[1]->id,
                'is_featured' => true,
                'is_flash_sale' => true,
                'image' => 'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?w=800&q=80',
                'tags' => ['mouse', 'rgb', 'wireless', 'office'],
            ],
            [
                'name' => 'AeroPulse Fast Charge 100W Power Bank 25000mAh',
                'price' => 4500.00,
                'b2b_price' => 3200.00,
                'sale_price' => 3900.00,
                'stock' => 80,
                'moq' => 5,
                'weight' => 0.45,
                'category_id' => $categoryModels[9]->id, // Power Banks
                'brand_id' => $brandModels[2]->id,
                'is_featured' => false,
                'is_flash_sale' => false,
                'image' => 'https://images.unsplash.com/photo-1609592424109-dd9892f1b177?w=800&q=80',
                'tags' => ['powerbank', '100w', 'fast-charge'],
            ],
            [
                'name' => 'Vanguard 4K UltraHD Curved Gaming Monitor 27"',
                'price' => 38000.00,
                'b2b_price' => 31000.00,
                'sale_price' => 34500.00,
                'stock' => 15,
                'moq' => 2,
                'weight' => 5.2,
                'category_id' => $categoryModels[7]->id, // Monitors
                'brand_id' => $brandModels[3]->id,
                'is_featured' => true,
                'is_flash_sale' => true,
                'image' => 'https://images.unsplash.com/photo-1527443224154-c4a3942d3acf?w=800&q=80',
                'tags' => ['4k', 'monitor', '144hz', 'curved'],
            ],
        ];

        $productModels = [];
        foreach ($productsData as $pData) {
            $imgUrl = $pData['image'];
            unset($pData['image']);

            $pData['slug'] = Str::slug($pData['name']);
            $pData['sku'] = 'SKU-' . strtoupper(Str::random(6));
            $pData['short_description'] = "High performance {$pData['name']} built for speed and durability.";
            $pData['description'] = "The {$pData['name']} is designed to deliver exceptional reliability and efficiency. Features include premium build quality, modern styling, and enterprise compatibility.";
            $pData['specifications'] = ['Warranty' => '2 Years', 'Condition' => 'Brand New', 'Origin' => 'China/Taiwan'];
            $pData['status'] = 'active';

            $product = Product::create($pData);
            $productModels[] = $product;

            ProductImage::create([
                'product_id' => $product->id,
                'image_url' => $imgUrl,
                'is_primary' => true,
                'sort_order' => 1,
            ]);

            // B2B Pricing Tiers
            B2BPriceTier::create(['product_id' => $product->id, 'min_quantity' => 1, 'max_quantity' => 9, 'unit_price' => $product->b2b_price]);
            B2BPriceTier::create(['product_id' => $product->id, 'min_quantity' => 10, 'max_quantity' => 49, 'unit_price' => round($product->b2b_price * 0.9, 2)]);
            B2BPriceTier::create(['product_id' => $product->id, 'min_quantity' => 50, 'max_quantity' => null, 'unit_price' => round($product->b2b_price * 0.82, 2)]);

            // Sample Reviews
            Review::create([
                'product_id' => $product->id,
                'user_id' => $b2cUser->id,
                'rating' => 5,
                'comment' => 'Outstanding performance and fast delivery! Highly recommended.',
                'is_approved' => true,
            ]);
        }

        // 4. Create Product Bundle ("Complete Your Setup")
        $bundle = ProductBundle::create([
            'name' => 'Ultimate Pro Gaming Setup',
            'primary_product_id' => $productModels[0]->id, // Laptop
            'discount_percentage' => 12.00,
            'is_active' => true,
        ]);

        ProductBundleItem::create(['bundle_id' => $bundle->id, 'product_id' => $productModels[2]->id]); // Mouse
        ProductBundleItem::create(['bundle_id' => $bundle->id, 'product_id' => $productModels[1]->id]); // Headphones

        // 5. Create Coupons & Settings
        Coupon::create([
            'code' => 'BESMART2026',
            'type' => 'percentage',
            'value' => 10.00,
            'min_order' => 1000.00,
            'max_discount' => 2000.00,
            'expires_at' => Carbon::now()->addYear(),
            'target_type' => 'all',
            'is_active' => true,
        ]);

        Coupon::create([
            'code' => 'BULKB2B',
            'type' => 'fixed',
            'value' => 5000.00,
            'min_order' => 50000.00,
            'expires_at' => Carbon::now()->addYear(),
            'target_type' => 'b2b',
            'is_active' => true,
        ]);

        FlashSale::create([
            'title' => 'Besmart Mega Flash Sale',
            'start_time' => Carbon::now(),
            'end_time' => Carbon::now()->addDays(3),
            'discount_percentage' => 20.00,
            'is_active' => true,
        ]);

        Setting::set('DEFAULT_DUTY_RATE', '15.0');
        Setting::set('DEFAULT_VAT_RATE', '15.0');
        Setting::set('STORE_NAME', 'Besmart Platform');

        // 6. Generate 10 Years of Historical B2B Orders (2016 to 2026)
        $startYear = 2016;
        $currentYear = 2026;

        for ($y = $startYear; $y <= $currentYear; $y++) {
            $ordersInYear = 3 + ($y - $startYear) * 2; // Increasing volume over years
            for ($i = 0; $i < $ordersInYear; $i++) {
                $month = rand(1, 12);
                $day = rand(1, 28);
                $orderDate = Carbon::create($y, $month, $day, rand(9, 18), rand(0, 59));

                $product = $productModels[array_rand($productModels)];
                $qty = rand(10, 80);
                $unitPrice = $product->getB2BUnitPrice($qty);
                $subtotal = round($unitPrice * $qty, 2);
                $discount = round($subtotal * 0.05, 2);
                $total = round($subtotal - $discount, 2);

                $order = Order::create([
                    'order_number' => 'ORD-B2B-' . $y . '-' . Str::upper(Str::random(5)),
                    'user_id' => $b2bUser->id,
                    'user_type' => 'b2b',
                    'subtotal' => $subtotal,
                    'discount_amount' => $discount,
                    'shipping_cost' => 0.00,
                    'tax_amount' => 0.00,
                    'total_amount' => $total,
                    'status' => 'delivered',
                    'payment_status' => 'paid',
                    'payment_method' => 'sslcommerz',
                    'shipping_address' => [
                        'name' => 'TechMart Warehouse',
                        'phone' => '+8801800000002',
                        'address' => 'Plot 14, Uttara Commercial Area',
                        'city' => 'Dhaka',
                    ],
                    'created_at' => $orderDate,
                    'updated_at' => $orderDate,
                ]);

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'sku' => $product->sku,
                    'unit_price' => $unitPrice,
                    'quantity' => $qty,
                    'subtotal' => $subtotal,
                    'created_at' => $orderDate,
                    'updated_at' => $orderDate,
                ]);

                Payment::create([
                    'order_id' => $order->id,
                    'gateway' => 'sslcommerz',
                    'transaction_id' => 'TXN-' . $y . '-' . Str::upper(Str::random(8)),
                    'amount' => $total,
                    'status' => 'completed',
                    'created_at' => $orderDate,
                    'updated_at' => $orderDate,
                ]);
            }
        }
    }
}
