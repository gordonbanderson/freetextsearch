<?php declare(strict_types = 1);

namespace Suilven\FreeTextSearch\Tests\Task;

use SilverStripe\Control\HTTPRequest;
use SilverStripe\Dev\SapphireTest;
use Suilven\FreeTextSearch\Task\ReindexTask;

class ReindexTaskTest extends SapphireTest
{
    public function testCreateIndexTask(): void
    {
        $getVars = ['index' => 'sitetree'];
        $request = new HTTPRequest('GET', '/dev/tasks/index', $getVars);
        $task = new ReindexTask();
        $task->run($request);

        // @todo assertions
    }
}
