<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonPath = database_path('data/products.json'); // Đọc từ file products.json

        if (!File::exists($jsonPath)) {
            $this->command->error("File không tìm thấy: " . $jsonPath);
            return;
        }

        $jsonData = File::get($jsonPath);
        $products = json_decode($jsonData, true);

        if (is_null($products)) {
             $this->command->error("Định dạng JSON không hợp lệ trong: " . $jsonPath);
             $this->command->error("Lỗi JSON: " . json_last_error_msg());
            return;
        }

        $uniqueCategories = [];
        foreach ($products as $product) {
            // Lấy tên category từ cột "category"
            $categoryName = $product['category'] ?? null;
            if ($categoryName && !isset($uniqueCategories[$categoryName])) {
                $uniqueCategories[$categoryName] = [
                    'name' => $categoryName,
                    'slug' => Str::slug($categoryName), // Tự động tạo slug
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Chuyển mảng kết hợp thành mảng tuần tự để insert
        $dataToInsert = array_values($uniqueCategories);

        // Insert dữ liệu mới
        if (!empty($dataToInsert)) {
            DB::table('categories')->insert($dataToInsert);
            $this->command->info("Nạp " . count($dataToInsert) . " categories duy nhất từ products.json thành công!");
        } else {
             $this->command->warn("Không tìm thấy dữ liệu category hợp lệ trong products.json.");
        }
    }
}
