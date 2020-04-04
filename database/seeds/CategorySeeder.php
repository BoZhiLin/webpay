<?php

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory('App\Entities\Category', 3)->create()
            ->each(function ($category) {
                $category->products()->save(factory('App\Entities\Product')->make());
            });
    }
}
