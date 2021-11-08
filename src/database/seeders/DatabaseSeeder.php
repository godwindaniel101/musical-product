<?php

namespace Database\Seeders;

use Exception;
use App\Models\User;
use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    { 
            DB::beginTransaction();
            try {
                $users = csvReaderHelper("csv/users.csv");
                foreach ($users as $user) {
                    $user['password'] = bcrypt($user['password']);
                    if (!User::where('email', $user['email'])->exists()) {
                        User::firstOrCreate($user);
                    }
                }

                $products = csvReaderHelper("csv/products.csv");
                foreach ($products as $product) {
                    Product::firstOrCreate($product);
                }

                $purchases = csvReaderHelper("csv/purchased.csv");
                foreach ($purchases as $purchase) {
                    Purchase::firstOrCreate($purchase);
                }
                DB::commit();
            } catch (Exception $e) {
                DB::rollBack();
                throw new Exception($e);
            }
        
    }
}
