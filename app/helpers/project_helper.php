<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Dump helper. Functions to dump variables to the screen, in a nicley formatted manner.
 * @author Joost van Veen
 * @version 1.0
 */
if (!function_exists('dump')) {
    function dump ($var, $label = 'Dump', $echo = TRUE)
    {
        // Store dump in variable 
        ob_start();
        var_dump($var);
        $output = ob_get_clean();
        
        // Add formatting
        $output = preg_replace("/\]\=\>\n(\s+)/m", "] => ", $output);
        $output = '<pre style="background: #FFFEEF; color: #000; border: 1px dotted #000; padding: 10px; margin: 10px 0; text-align: left;">' . $label . ' => ' . $output . '</pre>';
        
        // Output
        if ($echo == TRUE) {
            echo $output;
        }
        else {
            return $output;
        }
    }
}


if (!function_exists('dump_exit')) {
    function dump_exit($var, $label = 'Dump', $echo = TRUE) {
        dump ($var, $label, $echo);
        exit;
    }
}

function btn_delete ($uri)
{
	return anchor($uri, '<i class="fa fa-trash"></i> Delete', array(
		'onclick' => "return confirm('You are about to delete a record. This cannot be undone. Are you sure?');",
		'class'=> 'btn btn-danger pull-right'
	));
}

function e($string){
	return htmlentities($string);
}

function addAll(&$array1, $array2) {
    foreach ($array2 as $value) {
        $array1[] = $value;
    }
}

/**
 * inverse method
 *
 * @param int $x an integer value
 *
 * @return int
 */
function inverse($x)
    {
        if (!$x) {
            throw new Exception('Error: Division by zero.', E_USER_ERROR);
        } else {
            return 1/$x;
        }
    }

function convertToSeconds($hrs,$mins,$secs)
{
    
    $temp =  ($hrs * 3600) + ($mins*60) + $secs;
    return $temp;
}

function weekDays()
{
    return $days = array("Time intervals","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday");
}

        function createLectures(array $professors) {
// TODO Auto-generated method stub
        foreach ($professors as $professor) {
            $subjectsTaught = $professor->getSubjectTaught();
            foreach ($subjectsTaught as $subject) {
                $this->classes[] = (new Lecture($professor, $subject));
            }
        }
    }

    function rate($dna, $periods) {
    $mileage = 0;
    $slots = str_split($dna);
    for ($i = 0; $i < DAYS_COUNT - 1; $i++) {
        $mileage += $periods[$slots[$i]][$slots[$i+1]];
    }
    return $mileage;
    }


    function selection($param) {
    $choices = array($param);
    shuffle($choices);
    return implode('',$choices);
    }
    function mutation($parent1, $parent2) { # VERY INEFFICIENT! Combines genes randomly from both parents and if genes are repeated we do it again.
    // $child = "AAAAAA";
        $child = "";
        for($i = 0; $i < DAYS_COUNT; $i++) {
            $chosen = mt_rand(0,1);
            if ($chosen)
                $child .= substr($parent1, $i, 1);
            else
                $child .= substr($parent2, $i, 1);
        }
    return $child;
    }

    function converging($pop) {
    $items = count(array_unique($pop));
    if ($items == 1)
        return true;
    else
        return false;
}