<?php

class SignInCest
{
    /**
     * @param FunctionalTester $I
     */
    public function _before(FunctionalTester $I)
    {
        $I->haveRecord('users', [
            'name'     => 'Tony Stark',
            'email'    => 'tony@stark.com',
            'password' => bcrypt('tony.123'),
        ]);
    }

    /**
     * Prueba que haya determinados elementos en formulario de registro.
     *
     * @test
     * @param FunctionalTester $I
     */
    public function shouldHaveFormFields(FunctionalTester $I)
    {
        $I->amOnPage('/login');

        $I->see('Login', '.card-header');
        $I->seeElement('form input[name="_token"]');
        $I->seeElement('form input[name="email"]');
        $I->seeElement('form input[name="password"]');
        $I->seeElement('form button[type="submit"]');
    }

    /**
     * @test
     * @param FunctionalTester $I
     */
    public function shouldCreateAccountSuccessfullyAndLogInTheNewlyUser(FunctionalTester $I)
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
    }
}
