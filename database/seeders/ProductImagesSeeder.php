<?php

namespace Database\Seeders;

// Essential 'use' statements
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage; // Use the Storage facade
use App\Models\Product;                 // Use the Product model to find IDs
use Illuminate\Support\Str; // Added Str for potential slug comparison

class ProductImagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Starting Product Images Seeding...');

        // 1. Define path to the JSON file
        $jsonPath = database_path('data/products.json'); // Make sure this is correct

        // 2. Check JSON file existence
        if (!File::exists($jsonPath)) {
            $this->command->error("❌ Product JSON file not found: " . $jsonPath);
            return;
        }

        // 3. Read and decode JSON
        $jsonData = File::get($jsonPath);
        $productsData = json_decode($jsonData, true);

        // 4. Validate JSON
        if (is_null($productsData)) {
            $this->command->error("❌ Invalid JSON format in products file.");
            $this->command->error("   JSON Decode Error: " . json_last_error_msg());
            return;
        }

        // 5. Prepare arrays and counters
        $imagesToInsert = [];
        $totalProductsInJson = count($productsData);
        $processedCount = 0;
        $productsWithImagesLinked = 0;
        $totalImagesLinked = 0;
        $missingFolderCount = 0;
        $productNotFoundCount = 0;
        $noImagesInFolderCount = 0;

        // 6. Get Product map (name => id) for efficiency
        $productNameMap = Product::pluck('id', 'name')->toArray();
        // Optional: Get slug map if names are not unique but slugs are
        // $productSlugMap = Product::pluck('id', 'slug')->toArray();

        // 7. Loop through JSON product data
        foreach ($productsData as $index => $productJson) {
            $processedCount++;
            $productName = $productJson['title'] ?? null;
            // *** IMPORTANT: Verify this key matches your JSON file exactly ***
            $imageFolderName = $productJson['image_folder'] ?? null;

            // Basic check for essential data
            if (!$productName || !$imageFolderName) {
                // $this->command->line("<fg=yellow>Skipping row ".($index+1)." due to missing name or image folder key.</>");
                continue;
            }

            // 8. Find Product ID
            $productId = $productNameMap[$productName] ?? null;

            // Alternative lookup if names aren't unique (uncomment if needed)
            // if (!$productId) {
            //     $productSlug = Str::slug($productName); // Or however slugs were generated
            //     // Add logic here to find the correct unique slug if needed
            //     $productId = $productSlugMap[$productSlug] ?? null;
            // }

            if (!$productId) {
                // $this->command->line("<fg=yellow>-> Product not found in DB for name: \"{$productName}\"</>");
                $productNotFoundCount++;
                continue;
            }

            // 9. Construct relative folder path
            $relativeFolderPath = 'products/' . $imageFolderName;

            // 10. Check if folder exists using Storage facade
            if (!Storage::disk('public')->exists($relativeFolderPath)) {
                // $this->command->line("<fg=yellow>-> Image directory not found: storage/app/public/{$relativeFolderPath}</>");
                $missingFolderCount++;
                continue;
            }

            // 11. Get files within the directory
            $files = Storage::disk('public')->files($relativeFolderPath);

            if (empty($files)) {
                // $this->command->line("<fg=yellow>-> No files found in directory: {$relativeFolderPath}</>");
                $noImagesInFolderCount++;
                continue;
            }

            $imagesFoundForThisProduct = false;
            // 12. Prepare image data for insertion
            foreach ($files as $filePath) {
                // Filter for valid image extensions
                $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
                if (!in_array($extension, ['jpg', 'jpeg', 'png', 'webp', 'gif'])) {
                    // $this->command->line("<fg=gray>---> Skipping non-image file: {$filePath}</>");
                    continue; // Skip non-image files
                }

                $imagesToInsert[] = [
                    'product_id' => $productId,
                    'image_path' => $filePath, // Store relative path
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                $totalImagesLinked++;
                $imagesFoundForThisProduct = true; // Mark that images were found for this product
            }

            if ($imagesFoundForThisProduct) {
                $productsWithImagesLinked++; // Increment only if images were actually linked
            }

        } // End foreach loop

        // 14. Insert new image data in chunks
        if (!empty($imagesToInsert)) {
            $this->command->info("Inserting {$totalImagesLinked} images in chunks...");
            foreach (array_chunk($imagesToInsert, 500) as $chunk) { // Chunk size 500
                DB::table('product_images')->insert($chunk);
            }
            $this->command->info("✅ Successfully seeded " . $totalImagesLinked . " images for " . $productsWithImagesLinked . " products.");
        } else {
             // This is the warning you were seeing
            $this->command->warn("⚠️ No valid product images found or linked during the process.");
        }

        // 15. Summary Report
        $this->command->info("--- Seeding Summary ---");
        $this->command->info("Total product entries in JSON: " . $totalProductsInJson);
        $this->command->info("Products processed: " . $processedCount);
        if ($productNotFoundCount > 0) $this->command->warn("Products not found in DB: " . $productNotFoundCount);
        if ($missingFolderCount > 0) $this->command->warn("Image folders missing in storage: " . $missingFolderCount);
        if ($noImagesInFolderCount > 0) $this->command->warn("Folders existed but were empty: " . $noImagesInFolderCount);
        $this->command->info("Total images linked: " . $totalImagesLinked);
        $this->command->info("-----------------------");
    }
}