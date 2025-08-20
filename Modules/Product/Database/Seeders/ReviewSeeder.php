<?php

namespace Modules\Product\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Modules\Auth\Entities\User;
use Modules\Product\Entities\Item;
use Modules\Product\Entities\Review;
use Modules\Product\Entities\ReviewImage;
use Faker\Factory as Faker;
use Illuminate\Http\UploadedFile;

class ReviewSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        
        // Check if users exist, if not create a fake one
        if (User::count() === 0) {
            $this->command->info('No users found. Creating a fake user for reviews...');
            
            $user = User::create([
                'name' => $faker->name,
                'email' => 'review.user@example.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]);
            
            $users = [$user->id];
        } else {
            $users = User::pluck('id')->toArray();
        }

        $items = Item::pluck('id')->toArray();

        if (empty($items)) {
            $this->command->warn('No items found. Please run Item seeder first.');
            return;
        }

        // Get all review images from the directory
        $imageFiles = glob(resource_path('Seeding/Reviews/*.{jpg,jpeg,png,gif,webp}'), GLOB_BRACE);
        
        if (empty($imageFiles)) {
            $this->command->warn('No review images found in resources/Seeding/Reviews/');
        }

        $reviewsCount = 100; // Number of reviews to create

        for ($i = 0; $i < $reviewsCount; $i++) {
            $review = Review::create([
                'user_id' => $faker->randomElement($users),
                'item_id' => $faker->randomElement($items),
                'rating' => $faker->numberBetween(1, 5),
                'title' => $faker->sentence(3),
                'body' => $faker->paragraph(3),
                'purchase_verified' => $faker->boolean(70), // 70% chance of being true
            ]);

            // Add 1-3 random images to each review (if images exist)
            if (!empty($imageFiles)) {
                $imageCount = $faker->numberBetween(1, min(3, count($imageFiles)));
                $selectedImages = $faker->randomElements($imageFiles, $imageCount);
                
                foreach ($selectedImages as $imagePath) {
                    $filename = basename($imagePath);
                    $publicPath = 'reviews/' . $filename;
                    
                    // Copy the image to the storage directory
                    if (!file_exists(storage_path('app/public/reviews'))) {
                        mkdir(storage_path('app/public/reviews'), 0755, true);
                    }
                    
                    if (file_exists($imagePath)) {
                        copy($imagePath, storage_path('app/public/reviews/' . $filename));
                        
                        ReviewImage::create([
                            'review_id' => $review->id,
                            'image_url' => $publicPath,
                        ]);
                    }
                }
            }
        }

        $this->command->info('Reviews with images seeded successfully!');
        if (isset($user)) {
            $this->command->info('Fake user created with email: review.user@example.com and password: password');
        }
    }
}
