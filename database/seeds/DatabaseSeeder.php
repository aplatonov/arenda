<?php

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
        DB::table('roles')->insert([
            ['title' => 'Администратор', 'slug' => 'admin'],
            ['title' => 'Пользователь', 'slug' => 'user']
        ]);        

        DB::table('categories')->insert([
            ['name_cat' => 'Все объекты', 'parent_id' => 0]
        ]);    

        DB::table('users')->insert([
            ['login' => 'admin',
            'email' => 'a432974@yandex.ru',
            'password' => bcrypt('admin'),
            'name' => 'ООО "Техника в аренду"',
            'dopname' => 'менеджер Петрова Юлия',
            'phone' => '+7-927-456-78-90',
            'role_id' => 1,
            'valid' => true,
            'confirmed' => true],

            ['login' => 'user',
            'email' => 'fake@yandex.ru',
            'password' => bcrypt('user'),
            'name' => 'ИП "Копатель"',
            'dopname' => 'директор Копков Игорь',
            'phone' => '+7-123-456-78-90',
            'role_id' => 2,
            'valid' => true,
            'confirmed' => true]
        ]);
    }
}
