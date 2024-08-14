<?php

namespace App\Classes;

class SSR1Report
{
    public function headings() : array
    {
        return [
            'fullName' => 'Full Name',
            'designation' => 'Designation',
            'tenureType' => 'Tenure Type',
            'typeOfService' => 'Type of Service',
            'dateOfJoining' => 'Date of Joining'
        ];
    }
}
