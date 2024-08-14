<?php
if(!function_exists('getGrade')){
    function getGrade($marks_obtained, $grades)
    {
        foreach ($grades as $row) {
            if ($marks_obtained >= $row['percentage_from'] && $marks_obtained <= $row['percentage_to'])
                return $row;
        }
    }
}

if(!function_exists('getGradeFromGradePoint')){
    function getGradeFromGradePoint($grade_point, $grades)
    {
        foreach ($grades as $row) {
            if ($grade_point >= $row['grade_point'])
                return $row;
        }
    }
}

if(!function_exists('getRemarksFromPercentage')){
    function getRemarksFromPercentage($percentage, $percentages)
    {
        foreach ($percentages as $row) {
            if ($percentage >= $row['percentage_from'] && $percentage <= $row['percentage_to'])
                return $row->grade_name;
        }
    }
}
?>
