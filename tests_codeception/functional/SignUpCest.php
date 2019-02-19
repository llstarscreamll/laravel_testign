<?php

class SignUpCest
{
    /**
     * @param FunctionalTester $I
     */
    public function _before(FunctionalTester $I) {}

    /**
     * Prueba que haya determinados elementos en formulario de registro.
     *
     * @test
     * @param FunctionalTester $I
     */
    public function shouldHaveFormFields(FunctionalTester $I)
    {
        $I->amOnPage('/register');

        $I->see('Register', '.card-header');
        $I->seeElement('form input[name="_token"]');
        $I->seeElement('form input[name="name"]');
        $I->seeElement('form input[name="email"]');
        $I->seeElement('form input[name="password"]');
        $I->seeElement('form input[name="password_confirmation"]');
        $I->seeElement('form button[type="submit"]');
    }

    /**
     * @test
     * @param FunctionalTester $I
     */
    public function shouldCreateAccountSuccessfullyAndLogInTheNewlyUser(FunctionalTester $I)
    {
        $I->amOnPage('/register');

        $I->submitForm('form', [
            'name'                  => 'Tony Stark',
            'email'                 => 'tony@stark.com',
            'password'              => 'tony.123',
            'password_confirmation' => 'tony.123',
        ]);

        $I->seeCurrentUrlEquals('/home');
        $I->see('Dashboard', '.card-header');
        $I->see('You are logged in!', '.card-body');
        $I->see('Tony Stark', '#navbarSupportedContent');

        $I->seeRecord('users', [
            'name'  => 'Tony Stark',
            'email' => 'tony@stark.com',
        ]);
    }

    public function shouldShowErrorIfEmailInNotValid(FunctionalTester $I)
    {
        $I->amOnPage('/register');

        $I->submitForm('form', [
            'name'                  => 'Tony Stark',
            'email'                 => 'fake-email',
            'password'              => 'tony.123',
            'password_confirmation' => 'tony.123',
        ]);

        $I->seeCurrentUrlEquals('/register');
        $I->seeFormHasErrors();
        $I->see('The email must be a valid email address.', 'span.invalid-feedback');
    }
}
