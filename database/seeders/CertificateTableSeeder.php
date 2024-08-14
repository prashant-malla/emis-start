<?php

namespace Database\Seeders;

use App\Models\Certificate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CertificateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $certificate = Certificate::create([
            'name' => 'Certificate Sample',
            'sub_heading' => '<p><br />
            Affiliated to Tribhuvan University</p>
            
            <h3>INSTITUTE OF ENGINEERING</h3>
            ',
            'header_left' => 'S.No.: _______',
            'header_middle' => 'Character Certificate',
            'header_right' => 'TU Registration No.: {{admission}}<br>College Roll No.: {{roll}}',
            'content' => '<p>This is to certify that Mr/Ms <strong>{{sname}}</strong> son/daughter of Mr/Ms <strong>{{fatherName}}</strong>, <strong>{{motherName}}</strong> was the student of this college from _______ to _______ and has passed the Bachelor&#39;s Degree in _______ Engineering in the year _______ with _______.</p>

            <p>His/Her date of birth according to the college record is <strong>{{dob}}</strong>.</p>
            
            <p>His/Her conduct has been _______ throughout his/her stay in the college.<br />
            He/She bears a good moral character.</p>
            
            <p>We wish him/her success in his/her future endeavour.</p>
            ',
            'footer_left' => '__________________<br>Prepared by',
            'footer_middle' => 'Date: 2080-01-01',
            'footer_right' => '__________________<br>School Seal',
        ]);

        $certificate->addMedia(public_path('template/images/certificates/bg1.png'))->preservingOriginal()->toMediaCollection();
    }
}
