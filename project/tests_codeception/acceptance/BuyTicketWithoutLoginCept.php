<?php
$I = new AcceptanceTester($scenario ?? null);

$I->wantTo('Buy ticket without login');

$I->amOnPage('/routes');
$I->seeLink('Log in', '/login');
$I->seeLink('Register','/register');

$I->fillField('cityFrom', 'Kraków');
$I->fillField('cityTo', 'Biecz');

$I->click('Search Connections');

$I->seeCurrentUrlEquals('/routes/search');

$id = $I->grabFromDatabase('routes', 'id', [
    'cityFrom' => 'Kraków',
    'cityTo' => 'Biecz'
]);

$I->see('Travel Time');
$I->seeLink('Details', '/routes/'.$id.'/times');

$I->click('Details');

$I->seeCurrentUrlEquals('/routes/'.$id.'/times');

$I->see('Departure');
$I->see('Details');

$I->click('Buy');

$I->seeCurrentUrlEquals('/ticket/buy');

$I->see('Buying a ticket','h2');
$I->see('Departure: 12:00');
$I->see('Price: 23.95');

$I->click('Pay');

$I->seeCurrentUrlEquals('/ticket/buy');

$I->see('Departure: 12:00');
$I->see('Price: 23.95');
$I->see('The date field is required','li');

$day="2022-01-25";

$I->fillField('date', $day);
$I->click('Pay');

$I->see($day);

$id = $I->grabFromDatabase('tickets', 'id', [
    'cityFrom' => 'Kraków',
    'cityTo' => 'Biecz',
    'day'=>$day,
    'user_id'=>null
]);

$I->seeLink('Download', 'ticket/generatePDF'.$id);

