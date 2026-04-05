<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'مهام عاجلة', 'color' => 'danger'],      
            ['name' => 'مشاريع وبرمجة', 'color' => 'dark'],    
            ['name' => 'تطوير الذات', 'color' => 'primary'],    
            ['name' => 'المنزل والعائلة', 'color' => 'success'],
            ['name' => 'تسوق واحتياجات', 'color' => 'warning'], 
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}