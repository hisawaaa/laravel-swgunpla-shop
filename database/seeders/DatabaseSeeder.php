<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        //User::factory()->create([
        //    'name' => 'Test User',
        //    'email' => 'test@example.com',
        //]);
        $this->call([
            CategoriesSeeder::class,    
            BrandsSeeder::class,        
            ProductsSeeder::class,      
            ProductImagesSeeder::class, 
        ]);
        
        // Tạo 1 tài khoản Admin
        User::factory()->admin()->create([
            'name' => 'Admin SWGunpla',
            'email' => 'admin@swgunpla.test',
            'password' => bcrypt('password'), // Mật khẩu là 'password'
        ]);
    }
}
