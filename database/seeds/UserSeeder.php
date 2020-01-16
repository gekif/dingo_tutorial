<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = factory(User::class)->times(50)->create();

        foreach ($users as $user) {
            echo 'User generated. Email: ' . $user->email . PHP_EOL;
        }
    }
}
