<?php
/**
 * Created by PhpStorm.
 * User: Adminiator
 * Date: 2016-02-09
 * Time: 20:36
 */

namespace HSC;


class DocumentTest extends \PHPUnit_Framework_TestCase
{
    private $doc;

    function setUp() {
        $this->doc = new Document([
            'first' => new Entry('first', 'start_text', 'end_text')
        ]);
    }

    public function testEntrySize() {
        $this->assertEqual(count($this->doc->getEntries), 1);
    }

    public function testRetAlreadyCreatedEntry() {
        $doc = $this->doc;
        $entry = $doc->get('first');
        $this->assertInstanceOf($entry, Entry::class);
        $this->assertEqual($entry->name, 'first');
        $this->assertEqual($entry->str_start, 'start_text');
        $this->assertEqual($entry->str_end, 'end_text');
    }

    public function testRetCreatedNewEntry() {
        $doc = $this->doc;
        $entry  = $doc->get('second');
        $this->assertInstanceOf($entry, Entry::class);
        $this->assertEqual($entry->name, 'second');
        $this->assertEqual($entry->str_start, null);
        $this->assertEqual($entry->str_end, null);
        $this->assertTrue($doc->isChanged());
    }
}
