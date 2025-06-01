<?php

use App\Models\Box;
use App\Models\InventoryMovement;
use App\Models\Location;
use App\Models\Pallet;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        factory(User::class)->create([
            'id'    => 1,
            'name'  => 'Seed User',
            'email' => 'seed@example.com',
            'password' => bcrypt('secret'),
        ]);

        factory(Location::class, 5)->create();

        factory(Pallet::class, 10)->create()->each(function($pallet) {
            factory(Box::class, 3)->create([
                'pallet_id' => $pallet->id
            ])->each(function($box) {
                factory(InventoryMovement::class)->create([
                    'box_id' => $box->id
                ]);
            });
        });
    }
}
