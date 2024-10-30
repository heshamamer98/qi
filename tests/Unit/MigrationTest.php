<?php

namespace Tests\Unit;

use App\Jobs\Templates\SyncOpenSearchTemplateJob;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MigrationTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:refresh');
        $this->artisan('db:seed');
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $this->assertTrue(true);
    }
}
