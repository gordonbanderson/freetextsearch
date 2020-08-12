<?php declare(strict_types = 1);

namespace Suilven\FreeTextSearch\Tests\Task;

use SilverStripe\Control\HTTPRequest;
use SilverStripe\Dev\SapphireTest;
use Suilven\FreeTextSearch\Task\CreateIndexTask;

class CreateIndexTaskTest extends SapphireTest
{
    public function testCreateIndexTask(): void
    {
        $getVars = ['index' => 'sitetree'];
        $request = new HTTPRequest('GET', '/dev/tasks/create-index', $getVars);
        $task = new CreateIndexTask();
        $task->run($request);

        // @todo assertions
    }
}
