<?php declare(strict_types = 1);

namespace Suilven\FreeTextSearch\Tests\Factory;

use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Dev\SapphireTest;
use Suilven\FreeTextSearch\Implementation\IdentityIndexablePayloadMutator;

class IndexableMutatorPayloadTest extends SapphireTest
{
    protected static $fixture_file = ['tests/fixtures/sitetree.yml'];

    public function testMutator(): void
    {
        $page = SiteTree::get()->first();
        \error_log($page->Title);

        $payload = ['Title' => $page->Title];
        $mutator = new IdentityIndexablePayloadMutator();
        $mutator->mutatePayload($page, $payload);

        // @todo double check and fix this test.  Tired.
        \error_log(\print_r($payload, true));
        $this->assertEquals([
            'Title' => 'The Break In San Marino Is Bright',
            'Link' => '/the-break-in-san-marino-is-bright/',
        ], $payload['sitetree']);
    }
}
