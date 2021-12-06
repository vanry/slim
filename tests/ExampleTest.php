<?php

namespace Tests;

class ExampleTest extends TestCase
{
    public function test_example()
    {
        $this->get('/')
             ->assertResponseOk()
             ->assertSee('Slim');
    }
}
