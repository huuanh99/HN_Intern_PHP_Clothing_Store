<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginViewTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testLoginScreenCanBeRendered()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->assertSee('LOGIN');
        });
    }

    public function testUserCanNotAuthenticateWithInvalidPassword()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->type('email', 'abc@gmail.com')
                ->type('password', 'wrongpassword')
                ->press('LOGIN')
                ->assertPathIs('/login');
        });
    }

    public function testUserCanAuthenticateUsingTheLoginScreen()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->type('email', 'anh1@gmail.com')
                ->type('password', '12345678')
                ->press('LOGIN')
                ->assertPathIs('/');
        });
    }
}
