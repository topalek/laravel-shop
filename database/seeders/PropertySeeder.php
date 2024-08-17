<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $props = [
            ['title' => "Процессор"],
            ['title' => "Оперативная память"],
            ['title' => "Объем жесткого диска"],
            ['title' => "Тип жесткого диска"],
            ['title' => "Графическая карта"],
            ['title' => "Операционная система"],
            ['title' => "Размер экрана"],
            ['title' => "Разрешение экрана"],
            /*            ['title'=>"Тип экрана"],
                        ['title'=>"Порты"],
                        ['title'=>"Беспроводные технологии"],
                        ['title'=>"Веб-камера"],
                        ['title'=>"Вес"],
                        ['title'=>"Аккумулятор"],
                        ['title'=>"Гарантия"]*/
        ];
        $date = now();
        foreach ($props as &$prop) {
            $prop['created_at'] = $date;
            $prop['updated_at'] = $date;
        }
        DB::table('properties')->insert($props);
    }
}
