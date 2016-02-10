<?php
/**
 * Created by PhpStorm.
 * User: Adminiator
 * Date: 2016-02-09
 * Time: 20:28
 */

namespace HSC;


class Document
{
    private $entries;
    private $changed = false;

    /**
     * Document constructor.
     * @param $entries
     */
    public function __construct(array $entries)
    {
        $this->entries = $entries;
    }


    function get($name, $def_start, $def_end) {
        if(array_key_exists($name, $this->entries))
            return $this->entries[$name];
        $entry = new Entry();
        $entry->name = $name;
        $entry->str_start = $def_start;
        $entry->str_end = $def_end;
        $this->entries[$name] = $entry;
        $this->changed = true;

        return $entry;
    }

    /**
     * @return boolean
     */
    public function isChanged()
    {
        return $this->changed;
    }

    /**
     * @return array
     */
    public function getEntries()
    {
        return $this->entries;
    }

    function remove($name) {
        if(array_key_exists($name, $this->entries))
            unset($this->entries[$name]);
    }

    function __toString()
    {
        $res = '';
        foreach($this->entries as $entry)
            $res .= $entry->__toString();
        return $res;
    }


}