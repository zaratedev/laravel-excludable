<?php

namespace Zaratesystems\LaravelExcludable\Tests;

use Illuminate\Routing\Router;
use Orchestra\Testbench\TestCase as Orchestra;
use Zarate\Filterable\FilterableServiceProvider;
use Zarate\Filterable\Tests\Filters\UserFilter;
use Zarate\Filterable\Tests\Models\User;

class TestCase extends Orchestra
{
    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->loadLaravelMigrations(['--database' => 'sqlite']);
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'sqlite');

        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }
}
