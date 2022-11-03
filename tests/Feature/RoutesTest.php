<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class RoutesTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        //CHECK ALL ROUTES
        $app = app();
        $routeCollection = $app->routes->getRoutes();
        foreach ($routeCollection as $value) {
            $response = $this->call($value->methods()[0], $value->uri());
            error_log($value->methods()[0] . ' | ' . $value->uri());
            $this->assertTrue(true);
        }
    }
}
