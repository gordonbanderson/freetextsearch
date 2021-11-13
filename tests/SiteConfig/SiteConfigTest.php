<?php

declare(strict_types = 1);

namespace Suilven\FreeTextSearch\Tests\SiteConfig;

use SilverStripe\Dev\SapphireTest;
use SilverStripe\SiteConfig\SiteConfig;

class SiteConfigTest extends SapphireTest
{
    public function testUpdateCMSFields(): void
    {
        $siteConfig = SiteConfig::current_site_config();
        $fl = $siteConfig->getCMSFields();
        $fieldNames = $fl->dataFieldNames();
        $this->assertContains('BulkSize', $fieldNames);
        $this->assertContains('FreeTextSearchIndexingModeInBulk', $fieldNames);
    }
}
