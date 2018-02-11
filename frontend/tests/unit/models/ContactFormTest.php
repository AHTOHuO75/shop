<?php
namespace frontend\tests\unit\models;

use Yii;
use shop\forms\ContactForm;

class ContactFormTest extends \Codeception\Test\Unit
{
    public function testSendEmail()
    {
        $model = new ContactForm();

        $model->attributes = [
            'name' => 'Tester',
            'email' => 'tester@example.com',
            'subject' => 'very important letter subject',
            'body' => 'body of current message',
        ];

        expect_that($model->validate(['name', 'email', 'subject', 'body']));


    }
}
