<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use App\Models\User;
   
class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Category::create([
            'parent_id' => 0,
            'name' => 'التصميم الجرافيكي',
            'slug' => 'التصميم الجرافيكي',
            'description' => ' هذا هو وصف التصنيف ',
            'is_parent' => true,
            'status' => 'active',
            'image' => 'cat.png',
        ]);
    }
}