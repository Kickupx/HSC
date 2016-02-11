<?php
/**
 * Created by PhpStorm.
 * User: Adminiator
 * Date: 2016-02-09
 * Time: 20:18
 */

namespace HSC;


class ParserTest extends \PHPUnit_Framework_TestCase
{
    private $doc;

    function setUp() {
        $code =
            "
            <<<<<< Config
                Text, Text
                ===========
                More More
            >>>>>>> /Config

            <<<<<<<<< Super
                Start, Start
                ===============
                End End
            >>>>>>>>> /Super

            ";
        $parser = new Parser();
        $this->doc = $parser->parse($code);
    }

    private function assertHSCText($name, $start, $end) {
        $entries = $this->doc->getEntries();

        $this->assertArrayHasKey($name, $entries);
        $this->assertInstanceOf(Entry::class, $entries[$name]);

        $config = $entries[$name];
        $this->assertSame($config->name, $name);
        $this->assertContains($start, $config->str_start);
        $this->assertContains($end, $config->str_end);
    }

    public function testConfig() {
        $this->assertHSCText('Config', 'Text', 'More');
    }

    public function testSuper() {
        $this->assertHSCText('Super', 'Start', 'End');
    }
}
