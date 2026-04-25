<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'الخضروات والفواكه',
                'description' => 'أ freshest الخضروات والفواكه الطازجة يومياً',
                'icon' => 'leaf',
                'is_featured' => true,
                'sort_order' => 1,
                'children' => [
                    ['name' => 'خضروات طازجة', 'sort_order' => 1],
                    ['name' => 'فواكه طازجة', 'sort_order' => 2],
                    ['name' => 'أعشاب وتوابل', 'sort_order' => 3],
                    ['name' => 'سلطات جاهزة', 'sort_order' => 4],
                ]
            ],
            [
                'name' => 'اللحوم والدواجن',
                'description' => 'لحوم طازجة ودواجن عالية الجودة',
                'icon' => 'meat',
                'is_featured' => true,
                'sort_order' => 2,
                'children' => [
                    ['name' => 'لحوم بقرية', 'sort_order' => 1],
                    ['name' => 'دواجن', 'sort_order' => 2],
                    ['name' => 'لحوم ضأن', 'sort_order' => 3],
                    ['name' => 'لحوم مجمدة', 'sort_order' => 4],
                ]
            ],
            [
                'name' => 'الأسماك والمأكولات البحرية',
                'description' => 'أسماك طازجة ومأكولات بحرية يومياً',
                'icon' => 'fish',
                'is_featured' => true,
                'sort_order' => 3,
                'children' => [
                    ['name' => 'أسماك طازجة', 'sort_order' => 1],
                    ['name' => 'روبيان وقشريات', 'sort_order' => 2],
                    ['name' => 'أسماك مجمدة', 'sort_order' => 3],
                    ['name' => 'مأكولات بحرية معالجة', 'sort_order' => 4],
                ]
            ],
            [
                'name' => 'منتجات الألبان والبيض',
                'description' => 'ألبان طازجة وبيض عضوي',
                'icon' => 'milk',
                'is_featured' => true,
                'sort_order' => 4,
                'children' => [
                    ['name' => 'حليب وكريمة', 'sort_order' => 1],
                    ['name' => 'جبن', 'sort_order' => 2],
                    ['name' => 'زبادي ولبن', 'sort_order' => 3],
                    ['name' => 'بيض', 'sort_order' => 4],
                    ['name' => 'زبدة وسمن', 'sort_order' => 5],
                ]
            ],
            [
                'name' => 'المخبوزات',
                'description' => 'مخبوزات طازجة يومياً',
                'icon' => 'bread',
                'is_featured' => true,
                'sort_order' => 5,
                'children' => [
                    ['name' => 'خبز عربي', 'sort_order' => 1],
                    ['name' => 'خبز أوروبي', 'sort_order' => 2],
                    ['name' => 'كعك ومعجنات', 'sort_order' => 3],
                    ['name' => 'كيك وحلويات', 'sort_order' => 4],
                ]
            ],
            [
                'name' => 'المشروبات',
                'description' => 'مشروبات متنوعة ومنعشة',
                'icon' => 'drink',
                'is_featured' => false,
                'sort_order' => 6,
                'children' => [
                    ['name' => 'مياه', 'sort_order' => 1],
                    ['name' => 'عصائر', 'sort_order' => 2],
                    ['name' => 'مشروبات غازية', 'sort_order' => 3],
                    ['name' => 'قهوة وشاي', 'sort_order' => 4],
                    ['name' => 'مشروبات طاقة', 'sort_order' => 5],
                ]
            ],
            [
                'name' => 'المواد الغذائية الأساسية',
                'description' => 'كل ما تحتاجه لمطبخك',
                'icon' => 'grain',
                'is_featured' => false,
                'sort_order' => 7,
                'children' => [
                    ['name' => 'أرز وبقوليات', 'sort_order' => 1],
                    ['name' => 'معكرونة ونودلز', 'sort_order' => 2],
                    ['name' => 'زيوت وسمن', 'sort_order' => 3],
                    ['name' => 'سكر وملح وتوابل', 'sort_order' => 4],
                    ['name' => 'صلصات وكاتشب', 'sort_order' => 5],
                    ['name' => 'معلبات', 'sort_order' => 6],
                ]
            ],
            [
                'name' => 'المجمدات',
                'description' => 'منتجات مجمدة عالية الجودة',
                'icon' => 'snowflake',
                'is_featured' => false,
                'sort_order' => 8,
                'children' => [
                    ['name' => 'خضروات مجمدة', 'sort_order' => 1],
                    ['name' => 'فواكه مجمدة', 'sort_order' => 2],
                    ['name' => 'أطعمة جاهزة', 'sort_order' => 3],
                    ['name' => 'آيس كريم', 'sort_order' => 4],
                ]
            ],
            [
                'name' => 'العناية الشخصية',
                'description' => 'منتجات العناية الشخصية والنظافة',
                'icon' => 'heart',
                'is_featured' => false,
                'sort_order' => 9,
                'children' => [
                    ['name' => 'شامبو وبلسم', 'sort_order' => 1],
                    ['name' => 'صابون وغسول', 'sort_order' => 2],
                    ['name' => 'عناية بالأسنان', 'sort_order' => 3],
                    ['name' => 'عناية بالبشرة', 'sort_order' => 4],
                ]
            ],
            [
                'name' => 'منتجات التنظيف',
                'description' => 'منتجات تنظيف المنزل',
                'icon' => 'sparkles',
                'is_featured' => false,
                'sort_order' => 10,
                'children' => [
                    ['name' => 'منظفات المطبخ', 'sort_order' => 1],
                    ['name' => 'منظفات الحمام', 'sort_order' => 2],
                    ['name' => 'منظفات الغسيل', 'sort_order' => 3],
                    ['name' => 'منظفات الأرضيات', 'sort_order' => 4],
                    ['name' => 'مناديل ورقية', 'sort_order' => 5],
                ]
            ],
        ];

        foreach ($categories as $categoryData) {
            $children = $categoryData['children'] ?? [];
            unset($categoryData['children']);

            $parent = Category::create($categoryData);

            foreach ($children as $child) {
                $child['parent_id'] = $parent->id;
                Category::create($child);
            }
        }
    }
}
