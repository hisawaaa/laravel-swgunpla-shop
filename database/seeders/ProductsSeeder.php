<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Brand;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonPath = database_path('data/products.json'); // Đường dẫn đến file JSON sản phẩm

        if (!File::exists($jsonPath)) {
            $this->command->error("File không tìm thấy: " . $jsonPath);
            return;
        }

        $jsonData = File::get($jsonPath);
        // Decode JSON thành mảng PHP (true để thành mảng kết hợp)
        $products = json_decode($jsonData, true);

        // Kiểm tra JSON hợp lệ
        if (is_null($products)) {
             $this->command->error("Định dạng JSON không hợp lệ trong: " . $jsonPath);
             $this->command->error("Lỗi JSON: " . json_last_error_msg());
            return;
        }

        // Lấy ID của categories và brands để mapping
        // Sử dụng key là 'name' để dễ dàng tra cứu ID
        $categoryMap = Category::pluck('id', 'name')->toArray();
        $brandMap = Brand::pluck('id', 'name')->toArray();

        $dataToInsert = [];
        $existingSlugs = DB::table('products')->pluck('slug')->toArray(); // Lấy các slug đã tồn tại

        foreach ($products as $product) {
            // Lấy dữ liệu từ JSON, sử dụng ?? null để tránh lỗi nếu thiếu key
            $name = $product['title'] ?? null;
            $categoryName = $product['category'] ?? null;
            $brandName = $product['brand'] ?? null;
            $priceString = $product['price_formatted'] ?? '0';
            $stock = $product['stock_quantity'] ?? 0;
            $description = $product['full_description'] ?? null;

            // Kiểm tra các trường bắt buộc
            if (!$name || !$categoryName || !$brandName) {
                $this->command->warn("Bỏ qua sản phẩm do thiếu tên/category/brand: " . ($name ?? 'N/A'));
                continue; // Bỏ qua sản phẩm này
            }

            // Tìm ID tương ứng
            $categoryId = $categoryMap[$categoryName] ?? null;
            $brandId = $brandMap[$brandName] ?? null;

            if (!$categoryId) {
                $this->command->warn("Không tìm thấy Category cho sản phẩm '{$name}': '{$categoryName}'");
                continue; // Bỏ qua sản phẩm này
            }
             if (!$brandId) {
                $this->command->warn("Không tìm thấy Brand cho sản phẩm '{$name}': '{$brandName}'");
                continue; // Bỏ qua sản phẩm này
            }

            // Làm sạch giá (loại bỏ 'đ', '.', khoảng trắng) và chuyển thành số nguyên
            $price = (int) preg_replace('/[^\d]/', '', $priceString);

            // Tạo slug duy nhất
            $slugBase = Str::slug($name);
            $slug = $slugBase;
            $counter = 1;
            while (in_array($slug, $existingSlugs)) { // Kiểm tra trong mảng đã lấy + mảng đang tạo
                $slug = $slugBase . '-' . $counter++;
            }
            $existingSlugs[] = $slug; // Thêm slug mới vào danh sách đã tồn tại để kiểm tra lần sau

            $dataToInsert[] = [
                'name' => $name,
                'description' => $description,
                'price' => $price,
                'stock' => (int) $stock,
                'slug' => $slug,
                'category_id' => $categoryId,
                'brand_id' => $brandId,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Xóa dữ liệu cũ (tùy chọn, vì migrate:fresh đã xóa)
        // DB::table('products')->truncate();

        // Insert dữ liệu mới (chia nhỏ nếu cần)
        if (!empty($dataToInsert)) {
             foreach (array_chunk($dataToInsert, 200) as $chunk) { // Insert mỗi lần 200 bản ghi
                 DB::table('products')->insert($chunk);
             }
            $this->command->info("Nạp dữ liệu products từ JSON thành công!");
        } else {
             $this->command->warn("Không tìm thấy dữ liệu product hợp lệ trong JSON để nạp.");
        }
    }
}
