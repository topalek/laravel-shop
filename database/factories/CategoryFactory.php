<?php

namespace Database\Factories;

use Domain\Catalog\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Domain\Catalog\Models\Category>
 */
class CategoryFactory extends Factory
{
    protected $model = Category::class;
    private $categories = [
        'Смартфоны и аксессуары',
        'Ноутбуки и ультрабуки',
        'Планшеты',
        'Настольные компьютеры и моноблоки',
        'Телевизоры и домашние кинотеатры',
        'Аудиотехника',
        'Игровые консоли и аксессуары',
        'Смарт-часы и фитнес-браслеты',
        'Камеры и фотоаппараты',
        'Бытовая техника',
        'Компьютерные комплектующие',
        'Принтеры и сканеры',
        'Сетевое оборудование',
        'Устройства хранения данных',
        'Умный дом',
        'Автомобильная электроника',
        'Персональная техника',
        'Аксессуары для компьютеров',
        'Дроны и квадрокоптеры',
        'Виртуальная и дополненная реальность',
    ];

    public function definition(): array
    {
        return [
            'title' => fake()->randomElement($this->categories),
            'on_home_page' => fake()->boolean(),
            'sorting'      => fake()->numberBetween(1, 100),
        ];
    }
}
