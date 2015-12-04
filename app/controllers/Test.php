<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Test extends Backend_Controller
{

    public function __construct()
    {
        parent::__construct();
    }


    public function index()
    {
        $classes = $this->classes_model->get_all();
//            for($i = 0; $i <= 3; $i++){
//                shuffle($classes);
//                }
        foreach ($classes as $class) {
            $class_allocation = $this->classes_model->get_by('id', $class->id)->name;
//                echo $class_allocation;
        }


        $buildings = $this->room_model->get_all();
        for ($i = 0; $i <= 3; $i++) {
            shuffle($buildings);
        }
        foreach ($buildings as $building) {
            $room_allocation = $this->room_model->get_by('id', $building->id)->name;
            $lecture_allocation[] = $class_allocation . " (" . $room_allocation . ")";
        }

        /**
         * Displays the Room Number and Course Code For all Levels
         */
        foreach ($lecture_allocation as $lecture_allocate) {
            echo $this->display($lecture_allocate);
        }
    }

    function display($param)
    {
        $settings['day_start'] = 8;
        $settings['day_end'] = 16;
        $settings['break_time_start'] = 12;
        $settings['break_time_stop'] = 14;
        $settings['lecture_period'] = 2; //number of hours per lecture
        $settings['lecture_days'] = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday');

        echo '<table>
    <thead>
    <tr>
        <th colspan="5" class="text-center">SAMPLE TIME-TABLE FOR <?= $class; ?></th>
</tr>
<tr>
    <th>DAY\TIME</th>';
        for ($time = $settings['day_start']; $time < $settings['day_end']; $time += $settings['lecture_period']) {
            echo '<th>' . ($time) . "-" . ($time + $settings['lecture_period']) . '</th>';
        }
        echo '</tr>
</thead>
<tbody>';
//        foreach ($settings['lecture_days'] as $lecture_day) {
            echo '<tr>
    <td>' ./* $lecture_day .*/ '</td>';
            for ($time = $settings['day_start']; $time < $settings['day_end']; $time += $settings['lecture_period']) {
                echo '<td>';
                $mid_time = ($time + ($settings['lecture_period'] / 2));
                if ($mid_time >= $settings['break_time_start'] && $mid_time <= $settings['break_time_stop']) {
                    echo 'BREAK';
                } else {
                    echo $param;
                }
            }
            echo '</td>';
//}
//          echo '</tr>';
//        }
//echo '</tbody>
//</table>';
//}

//    function my_array_merge(&$array1, &$array2) {
//        $result = Array();
//        foreach($array1 as $key => &$value) {
//            $result[$key] = array_merge($value, $array2[$key]);
//        }
//        return $result;
//    }
//        }
        /**
         * Tested
         */

    }
}
/* End of file Test.php */
/* Location: .//opt/lampp/htdocs/project/app/controllers/Test.php */