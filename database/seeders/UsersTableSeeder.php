<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $param = [
          'name' => 'test1',
          'email' => 'test1@mail.com',
          'password' => 'password'
        ];
        DB::table('users')->insert($param);

        $param = [
            'name' => 'test2',
            'email' => 'test2@mail.com',
            'password' => 'password'
        ];
        DB::table('users')->insert($param);

        $param = [
            'name' => 'test3',
            'email' => 'test3@mail.com',
            'password' => 'password'
        ];
        DB::table('users')->insert($param);
        $param = [
            'name' => 'test4',
            'email' => 'test4@mail.com',
            'password' => 'password'
        ];
        DB::table('users')->insert($param);

        $param = [
            'name' => 'test5',
            'email' => 'test5@mail.com',
            'password' => 'password'
        ];
        DB::table('users')->insert($param);
    }
}
