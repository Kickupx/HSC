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
        $this->assertSame(count($this->doc->getEntries()), 1);
    }

    public function testRetAlreadyCreatedEntry() {
        $doc = $this->doc;
        $entry = $doc->get('first');
        $this->assertInstanceOf(Entry::class, $entry);
        $this->assertSame($entry->name, 'first');
        $this->assertSame($entry->str_start, 'start_text');
        $this->assertSame($entry->str_end, 'end_text');
    }

    public function testRetCreatedNewEntry() {
        $doc = $this->doc;
        $entry  = $doc->get('second');
        $this->assertInstanceOf(Entry::class, $entry);
        $this->assertSame($entry->name, 'second');
        $this->assertSame($entry->str_start, '');
        $this->assertSame($entry->str_end, '');
        $this->assertTrue($doc->isChanged());
    }
}
