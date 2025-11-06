<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class BrandsSeeder extends Seeder
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

        $uniqueBrands = [];
        $processedKeys = []; // Mảng để lưu key đã chuẩn hóa (viết thường)

        foreach ($products as $product) {
            // Lấy tên brand từ cột "brand"
            $brandName = $product['brand'] ?? null;

            if ($brandName) {
                // Chuẩn hóa key để kiểm tra (ví dụ: chuyển thành viết thường)
                $normalizedKey = strtolower($brandName);

                // Chỉ thêm nếu key chuẩn hóa này chưa được xử lý
                if (!isset($processedKeys[$normalizedKey])) {
                    $uniqueBrands[] = [ // Thêm trực tiếp vào mảng tuần tự
                        'name' => $brandName, // Lưu tên gốc (hoặc tên đầu tiên gặp)
                        'slug' => Str::slug($brandName), // Tự động tạo slug từ tên gốc
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                    // Đánh dấu key chuẩn hóa này đã được xử lý
                    $processedKeys[$normalizedKey] = true;
                }
            }
        }

        // Dữ liệu đã sẵn sàng để insert
        $dataToInsert = $uniqueBrands;

        // Insert dữ liệu mới
        if (!empty($dataToInsert)) {

            DB::table('brands')->insert($dataToInsert);

            $this->command->info("Nạp " . count($dataToInsert) . " brands duy nhất từ products.json thành công!");
        } else {
             $this->command->warn("Không tìm thấy dữ liệu brand hợp lệ trong products.json.");
        }
    }
}
