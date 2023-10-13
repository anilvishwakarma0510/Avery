<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CategoryModel;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $insert = [
            [
                'title' => 'Hot Gist Of The Moment',
                'color' => '#edf125',
                'slug' => '',
            ],
            [
                'title' => 'Fashion/Beauty',
                'color' => '#FFE49B',
                'slug' => '',
            
            ],
            [
                'title' => 'My Playlist of the Week',
                'color' => '#A49BFF',
                'slug' => '',
            
            ],
            [
                'title' => 'Young Stars of the Moment',
                'color' => '#68E1EC',
                'slug' => '',
            
            ],
            [
                'title' => 'Money Tips',
                'color' => '#68EC8B',
                'slug' => '',
            
            ],
            [
                'title' => 'This Week Extras',
                'color' => '#D368EC',
                'slug' => '',
            
            ],
            [
                'title' => 'Quotes and End Note',
                'color' => '##EC6895',
                'slug' => '',
            ]
        ];
        CategoryModel::insert($insert);
    }
}
