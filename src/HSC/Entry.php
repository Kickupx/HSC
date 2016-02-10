<?php

namespace HSC;

/**
 * Created by PhpStorm.
 * User: Adminiator
 * Date: 2016-02-09
 * Time: 20:12
 */
class Entry
{
    public $name;
    public $str_start;
    public $str_end;

    /**
     * Entry constructor.
     * @param $name
     * @param $str_start
     * @param $str_end
     */
    public function __construct($name = null, $str_start = null, $str_end = null)
    {
        $this->name = $name;
        $this->str_start = $str_start;
        $this->str_end = $str_end;
    }


    function __toString()
    {
        $name = $this->name;
        $start = $this->str_start;
        $end = $this->str_end;
        return "<<<<< $name \n $start \n ===== \n $end >>>>> /$name \n";
    }
}