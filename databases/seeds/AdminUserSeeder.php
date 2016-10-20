<?php

use Notadd\Foundation\Database\Seeder;
use Notadd\Foundation\Member\Abstracts\Member;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Member::create([
            'name' => '123546456',
            'email' => '4456456@admin.com',
            'password' => bcrypt('123456789'),
        ]);
    }
}
