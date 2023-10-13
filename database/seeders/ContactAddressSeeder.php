<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ContactAddressModel;

class ContactAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $insert = [
            'phone'=>'+41 2323 455455',
            'email'=>'contact@averystake.com',
            'address'=>'Street #1, Hugston Road, England',
        ];
        ContactAddressModel::create($insert);
    }
}
