<?php

namespace Tests\Feature\Currency;

use App\Models\User;
use Tests\TestCase;

class CurrencyAuthenticationTest extends TestCase
{
    /**
     * Test user is redirected to login before currencies page
     */
    public function test_currencies_screen_cannot_be_rendered_without_authentication(): void
    {
        $response = $this->get('/currencies');

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * Test user can see currencies page after login
     */
    public function test_currencies_screen_is_rendered_for_authenticated_users(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/currencies');

        $response->assertStatus(200);
    }
}
