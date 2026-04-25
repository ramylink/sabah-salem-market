<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            ['name' => 'صباح السالم', 'is_featured' => true, 'sort_order' => 1],
            ['name' => 'المراعي', 'is_featured' => true, 'sort_order' => 2],
            ['name' => 'نستله', 'is_featured' => true, 'sort_order' => 3],
            ['name' => 'كوكا كولا', 'is_featured' => false, 'sort_order' => 4],
            ['name' => 'بيبسي', 'is_featured' => false, 'sort_order' => 5],
            ['name' => 'أمريكانا', 'is_featured' => true, 'sort_order' => 6],
            ['name' => 'الفاضل', 'is_featured' => false, 'sort_order' => 7],
            ['name' => 'السنبلة', 'is_featured' => false, 'sort_order' => 8],
            ['name' => 'الصفوة', 'is_featured' => false, 'sort_order' => 9],
            ['name' => 'الجبر', 'is_featured' => false, 'sort_order' => 10],
            ['name' => 'الكويتية', 'is_featured' => true, 'sort_order' => 11],
            ['name' => 'الأولى', 'is_featured' => false, 'sort_order' => 12],
            ['name' => 'الأمير', 'is_featured' => false, 'sort_order' => 13],
            ['name' => 'زيتون', 'is_featured' => false, 'sort_order' => 14],
            ['name' => 'الفريج', 'is_featured' => false, 'sort_order' => 15],
        ];

        foreach ($brands as $brand) {
            Brand::create($brand);
        }
    }
}
