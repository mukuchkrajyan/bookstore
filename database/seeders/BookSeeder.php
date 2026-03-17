<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        Book::insert([
            [
                'title' => 'The Alchemist',
                'author' => 'Paulo Coelho',
                'price' => 12.50,
                'stock' => 7,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Atomic Habits',
                'author' => 'James Clear',
                'price' => 15.90,
                'stock' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'The Psychology of Money',
                'author' => 'Morgan Housel',
                'price' => 14.20,
                'stock' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => '1984',
                'author' => 'George Orwell',
                'price' => 11.30,
                'stock' => 9,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'To Kill a Mockingbird',
                'author' => 'Harper Lee',
                'price' => 13.40,
                'stock' => 8,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Sapiens: A Brief History of Humankind',
                'author' => 'Yuval Noah Harari',
                'price' => 18.00,
                'stock' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Thinking, Fast and Slow',
                'author' => 'Daniel Kahneman',
                'price' => 16.70,
                'stock' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'The Hobbit',
                'author' => 'J.R.R. Tolkien',
                'price' => 17.50,
                'stock' => 11,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}