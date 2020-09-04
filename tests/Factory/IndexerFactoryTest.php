<?php declare(strict_types = 1);

namespace Suilven\FreeTextSearch\Tests\Factory;

use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Dev\SapphireTest;
use Suilven\FreeTextSearch\Factory\IndexerFactory;
use Suilven\FreeTextSearch\Tests\Mock\Indexer;

class IndexerFactoryTest extends SapphireTest
{
    protected static $fixture_file = ['tests/fixtures/sitetree.yml'];

    public function testFactory(): void
    {
        Indexer::resetIndexedPayload();

        $factory = new IndexerFactory();

        /** @var \Suilven\FreeTextSearch\Tests\Mock\Indexer $indexer */
        $indexer = $factory->getIndexer();
        $this->assertInstanceOf('Suilven\FreeTextSearch\Interfaces\Indexer', $indexer);
        $this->assertInstanceOf('Suilven\FreeTextSearch\Tests\Mock\Indexer', $indexer);

        $indexer->setIndexName('sitetree');
        $page = $this->objFromFixture(SiteTree::class, 'sitetree_20');
        $indexer->index($page);

        // the mock stores the indexed content.  Firstly check that members and flickrphotos have no updates
        $allDocumentsPayload = Indexer::getIndexedPayload();
        $this->assertEquals(1, \sizeof($allDocumentsPayload));
        $indexedDocumentPayload = $allDocumentsPayload[0];

        $this->assertEquals([], $indexedDocumentPayload['members']);
        $this->assertEquals([], $indexedDocumentPayload['flickrphotos']);

        // check non timestamped data for the page in question
        $siteTreePayload = $indexedDocumentPayload['sitetree'];
        $this->assertEquals('The None In San Marino Is Full', $siteTreePayload['Title']);
        $this->assertEquals('The None In San Marino Is Full', $siteTreePayload['MenuTitle']);
        $this->assertEquals(
            'Ella opened the good and found that it led into a big close, not much larger than a might.',
            $siteTreePayload['Content']
        );
        $this->assertEquals(21, $siteTreePayload['Sort']);
        $this->assertEquals(0, $siteTreePayload['ParentID']);
    }
}
