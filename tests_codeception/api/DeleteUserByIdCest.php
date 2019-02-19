<?php

class DeleteUserByIdCest
{
    /**
     * @var string
     */
    private $endpoint = 'api/users/:id/';

    /**
     * @var int
     */
    private $userId;

    /**
     * @param ApiTester $I
     */
    public function _before(ApiTester $I)
    {
        $this->userId = $I->haveRecord('users', [
            'name'     => 'Tony Stark',
            'email'    => 'tony@stark.com',
            'password' => bcrypt('tony.123'),
            'type'     => 'client',
        ]);
    }

    /**
     * @param ApiTester $I
     */
    public function shouldDeleteSaidUserSuccessfully(ApiTester $I)
    {
        $I->sendDELETE(str_replace(':id', $this->userId, $this->endpoint));

        $I->seeResponseCodeIs(202);
        $I->dontSeeRecord('users', [
            'id'    => $this->userId,
            'name'  => 'Tony Stark',
            'email' => 'tony@stark.com',
        ]);
    }

    /**
     * @param ApiTester $I
     */
    public function shouldReturnNotFoundStatusCodeIfUserDoesNotExists(ApiTester $I)
    {
        $I->sendDELETE(str_replace(':id', 234567, $this->endpoint));

        $I->seeResponseCodeIs(404);
    }

    /**
     * @param ApiTester $I
     */
    public function shouldFoo(ApiTester $I)
    {
        $I->sendDELETE(str_replace(':id', '', $this->endpoint));

        $I->seeResponseCodeIs(404);
    }

    /**
     * @param ApiTester $I
     */
    public function shouldDontDeleteAdmin(ApiTester $I)
    {
        $userId = $I->haveRecord('users', [
            'name'     => 'Tony Stark',
            'email'    => 'foo@stark.com',
            'password' => bcrypt('tony.123'),
            'type'     => 'admin',
        ]);

        $I->sendDELETE(str_replace(':id', $userId, $this->endpoint));
        $I->seeResponseCodeIs(400);
        $I->seeResponseContainsJson(
            [
                'The users admin can`t delete',
            ]
        );
    }
}
