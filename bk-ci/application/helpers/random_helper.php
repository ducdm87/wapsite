<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
/**
 * Ramdom string plugin for CodeIgniter applications
 * @author : Samuel Sanchez, March 2009, http://www.kromack.com/ 
 * @license : free
 * @see http://www.kromack.com/codeigniter/plugin-random-pour-codeigniterplugin-random-pour-codeigniter/ 
 */
 
 
    /**
    * Return a ramdom string of $lenght size.
    *
    * @param int $lenght
    * @return string
    */
    function generate($lenght)
    {
        $ensemble = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', '1', '2', '3', '4');
 
        if($lenght > sizeof($ensemble)) {
 
            while($lenght > sizeof($ensemble)) {
 
                foreach($ensemble as $row) {
 
                    $ensemble[] = $row;
                }
            }
        }
 
        $ramdom = array_rand($ensemble, $lenght);
 
        $string = '';
 
        foreach($ramdom as $i)
        {
             $string = $string . $ensemble[$i];
        }
 
        return $string;
    }       
 
       /**
    * Return a ramdom int of $lenght size.
    *
    * @param int $lenght
    * @return string
    */
    function generateInt($lenght)
    {
        $ensemble = array('1', '2', '3', '4', '5', '6', '7', '8', '9');
 
        if($lenght > sizeof($ensemble)) {
 
            while($lenght > sizeof($ensemble)) {
 
                foreach($ensemble as $row) {
 
                    $ensemble[] = $row;
                }
            }
        }        
        $ramdom = array_rand($ensemble, $lenght);
 
        $string = '';
 
        foreach($ramdom as $i)
        {
             $string = $string . $ensemble[$i];
        }
 
        return $string;
    } 
 
?>  