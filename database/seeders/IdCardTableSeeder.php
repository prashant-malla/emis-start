<?php

namespace Database\Seeders;

use App\Models\IdCard;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IdCardTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $idCard = IdCard::create([
            'name' => 'Id Card Sample',
            'header' => '<h3>TEST ENGINEERING COLLEGE</h3>

            <p>TINKUNE, KATHMANDU</p>
            ',
            'primary_color' => '#ffffff',
            'secondary_color' => '#ffffff',
            'valid_upto' => '2081-12-30',
            'fields' => [
                'admission' => 'Admission No.',
                'roll' => 'Roll No.',
                'level' => 'Level',
                'program' => 'Programme',
                'yearSemester' => 'Year/Semester',
                'section' => 'Section',
                'bloodgroup' => 'Blood Group',
                'dob' => 'Date of Birth'
            ],
            'theme' => 'theme1',
        ]);

        $idCard->addMedia(public_path('template/images/id_cards/bg1.jpg'))->preservingOriginal()->toMediaCollection();
        $idCard->addMedia(public_path('template/images/id_cards/signature.png'))->preservingOriginal()->toMediaCollection('signature');
    }
}
