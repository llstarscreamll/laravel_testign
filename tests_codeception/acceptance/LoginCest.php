<?php

class LoginCest
{
    /**
     * @param AcceptanceTester $I
     */
    public function _before(AcceptanceTester $I)
    {
        $user = $I->have(\App\User::class, [
            'name'     => 'Tony Stark',
            'email'    => 'tony@stark.com',
            'password' => bcrypt('tony.123'),
        ]);
    }

    /**
     * @param AcceptanceTester $I
     */
    public function _after(AcceptanceTester $I)
    {
        \App\User::where(['name' => 'Tony Stark', 'email' => 'tony@stark.com'])->delete();
    }

    /**
     * @test
     * @param AcceptanceTester $I
     */
    public function shouldHaveFormFields(AcceptanceTester $I)
    {
        $I->amOnPage('/login');

        $I->see('Login', '.card-header');
        $I->seeElement('form');
        $I->seeElement('form input[name="email"]');
        $I->seeElement('form input[name="password"]');
        $I->seeElement('form button[type="submit"]');

        $I->wait(1);
    }

    /**
     * @test
     * @param AcceptanceTester $I
     */
    public function shouldCreateAccountSuccessfullyAndLogInTheNewlyUser(AcceptanceTester $I)
    {
        $I->amOnPage('/login');

        $I->submitForm('form', [
            'email'    => 'tony@stark.com',
            'password' => 'tony.123',
        ]);

        $I->seeCurrentUrlEquals('/home');
        $I->see('Dashboard', '.card-header');
        $I->see('You are logged in!', '.card-body');
        $I->see('Tony Stark', '#navbarSupportedContent');

        $I->wait(1);
    }
}
