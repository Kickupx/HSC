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
    private $entries;

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
        $this->entries = $parser->parse($code);
    }

    private function assertHSCText($name, $start, $end) {
        $entries = $this->entries;

        $this->assertContains($entries, $name);
        $this->assertInstanceOf($entries[$name], Entry::class);

        $config = $entries[$name];
        $this->assertEqual($config->name, $name);
        $this->assertContains($config->str_start, $start);
        $this->assertContains($config->str_end, $end);
    }

    public function testConfig() {
        $this->assertHSCText('Config', 'Text', 'More');
    }

    public function testSuper() {
        $this->assertHSCText('Super', 'Start', 'End');
    }

    public function testDocumentHelper() {
        $code = "";
        $parser = new Parser();
        $this->assertInstanceof($code->parseWithDoc($code), Document::class);
    }
}
