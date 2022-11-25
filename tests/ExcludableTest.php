<?php

namespace Zaratesystems\LaravelExcludable\Tests;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Zaratesystems\LaravelExcludable\Excludable;

class ExcludableTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_allows_to_exclude_results_by_id()
    {
        ExcludableStub::insert([
            ['id' => 1, 'title' => 'Test title 1'],
            ['id' => 4, 'title' => 'Test title 2'],
            ['id' => 42, 'title' => 'Test title 3'],
        ]);

        $this->assertEquals(2, ExcludableStub::exclude(42)->count());
    }

    /** @test */
    public function it_allows_to_exclude_results_by_passing_an_array_of_ids()
    {
        ExcludableStub::insert([
            ['id' => 1, 'title' => 'Test title 1'],
            ['id' => 4, 'title' => 'Test title 2'],
            ['id' => 42, 'title' => 'Test title 3'],
            ['id' => 66, 'title' => 'Test title 4'],
        ]);

        $this->assertEquals(2, ExcludableStub::exclude([42, 66])->count());
    }

    /** @test */
    public function it_allows_to_exclude_results_passing_a_collection()
    {
        $excluded = new Collection([
            ExcludableStub::create(['title' => 'Test excluded title 1']),
            ExcludableStub::create(['title' => 'Test excluded title 2']),
        ]);
        $expected = ExcludableStub::create(['title' => 'Test title']);

        $collection = ExcludableStub::exclude($excluded)->get();
        $this->assertTrue($collection->contains($expected));
        $this->assertEquals(1, $collection->count());
    }

    /** @test */
    public function it_allows_to_exclude_results_by_model()
    {
        $excluded = ExcludableStub::create(['title' => 'Test title 1']);
        $expected = ExcludableStub::create(['title' => 'Test title 2']);

        $collection = ExcludableStub::exclude($excluded)->get();
        $this->assertTrue($collection->contains($expected));
        $this->assertEquals(1, $collection->count());
    }

    /** @test */
    public function it_works_when_excluded_object_is_null()
    {
        $excluded = null;
        $expected = ExcludableStub::create(['title' => 'Test title 1']);

        $collection = ExcludableStub::exclude($excluded)->get();
        $this->assertTrue($collection->contains($expected));
        $this->assertEquals(1, $collection->count());
    }

    /** @test */
    public function it_allows_to_customize_the_exclude_column()
    {
        $excluded = ExcludableStub::create(['title' => 'Test excluded title']);
        $expected = ExcludableStub::create(['title' => 'Test title']);

        $collection = ExcludableStub::exclude($excluded->title, 'title')->get();
        $this->assertTrue($collection->contains($expected));
        $this->assertEquals(1, $collection->count());
    }

    /**
     * Refresh the in-memory database.
     *
     * @override \Illuminate\Foundation\Testing\RefreshDatabase
     *
     * @return void
     */
    protected function refreshDatabase()
    {
        Schema::create('excludable_stubs', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('title')->nullable();
            $table->timestamps();
        });

        $this->app[Kernel::class]->setArtisan(null);
    }
}

class ExcludableStub extends Model
{
    use Excludable;

    /**
     * Indicates if all mass assignment is enabled.
     *
     * @var bool
     */
    protected static $unguarded = true;
}
