<?php

namespace Tests\Feature;

use Tests\TestCase;

class LegalRoutesTest extends TestCase
{
    /**
     * Test que les routes légales sont accessibles
     */
    public function test_legal_routes_are_accessible()
    {
        $routes = [
            'privacy' => '/politique-de-confidentialite',
            'terms' => '/conditions-utilisation',
            'contact' => '/contact',
        ];

        foreach ($routes as $name => $url) {
            $response = $this->get($url);
            $response->assertStatus(200);
            $response->assertViewIs("legal.{$name}");
        }
    }

    /**
     * Test que les routes ont les bons noms
     */
    public function test_legal_routes_have_correct_names()
    {
        $this->assertTrue(route('privacy') === url('/politique-de-confidentialite'));
        $this->assertTrue(route('terms') === url('/conditions-utilisation'));
        $this->assertTrue(route('contact') === url('/contact'));
    }
}
