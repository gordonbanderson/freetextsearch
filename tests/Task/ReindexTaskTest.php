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
        $response = $task->run($request);

        // no response is returned from the task if it is successful
        $this->assertNull($response);
    }


    public function testCreateIndexTaskNoAccess(): void
    {
        $getVars = ['index' => 'sitetree', 'fail' => 1];
        $request = new HTTPRequest('GET', '/dev/tasks/index', $getVars);
        $task = new ReindexTask();
        $response = $task->run($request);

        $this->assertEquals(403, $response->getStatusCode());
    }
}
