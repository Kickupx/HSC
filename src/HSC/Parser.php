<?php

namespace HSC;
use WaitingFor\Regexes;

/**
 * Created by PhpStorm.
 * User: Adminiator
 * Date: 2016-02-09
 * Time: 20:10
 */
class Parser
{
    private $parser;

    private $state = State::No;
    private $nextState = State::No;
    private $name = '';
    private $entry;
    private $doc;
    private $str_start;
    private $str;

    function __construct()
    {
        $regexes = new Regexes();

        $regexes->add('/<<<<<[<]*/', function(array $capture) {
            $this->log('start', $capture);
            switch($this->state) {
                case State::No: $this->state = State::Name; break;
                case State::Name: throw new \Exception('Is waiting for name. Encountered <<<<<<...'); break;
            }
        });

        $regexes->add('/=====[=]*/', function(array $capture) {
            $this->log('middle', $capture);
            switch($this->state) {
                case State::Name: throw new \Exception('Expected name but got ====='); break;
                case State::Middle: {
                    $this->entry->str_start = substr($this->str, $this->str_start, $capture[1] - $this->str_start);
                    $this->str_start = $capture[1] + strlen($capture[0]);
                    $this->state = State::End;
                }
            }
        });

        $regexes->add('/>>>>>[>]*/', function(array $capture) {
            $this->log('end', $capture);
            switch($this->state) {
                case State::Name: throw new \Exception('Is waiting for name Encountered <<<<<...'); break;
                case State::End: {
                    $this->entry->str_end = substr($this->str, $this->str_start, $capture[1] - $this->str_start);
                    $this->state = State::EndName; break;
                }
            }
        });

        $regexes->add('/[a-zA-Z0-9_.]+/', function(array $capture) {
            $this->log('name', $capture);
            $name = $this->name;
            switch($this->state) {
                case State::Name: {
                    $this->name = $capture[0];
                    $this->entry = new Entry($capture[0]);
                    $this->state = State::NewRow;
                    $this->nextState = State::Middle;
                    break;
                }
                case State::EndName: {
                    if ($this->name != $capture[0])
                        throw new \Exception("Expected end name ${$name}. Got ${$capture[0]}");
                    $this->state = State::No;
                    $this->doc->addEntry($this->entry);
                }
            }
        });

        $regexes->add("/\n\r|\r\n|\n|\r/", function(array $capture) {
            $this->log('new_row', $capture);
            switch($this->state) {
                case State::Name: throw new \Exception('Expecting a name before line break'); break;
                case State::EndName: throw new \Exception('Expecting a end name before line break'); break;
                case State::NewRow: {
                    $this->str_start = $capture[1] + strlen($capture[0]);
                    $this->state = $this->nextState;
                }
            }
        });

        $this->parser = $regexes;
    }

    function parse($str) {
        $this->state = State::No;
        $this->nextState = State::No;
        $this->name = '';
        $this->entry = null;
        $this->doc = new Document();
        $this->str_start = 0;
        $this->str = $str;

        $this->parser->match($str)->all();
        return $this->doc;
    }

    private function log($name, array $capture) {
        /**
         * unset($capture['delegate']);
        echo $this->state . "\n";
        echo $name;
        echo ': ';
        print_r($capture);
         */
    }
}