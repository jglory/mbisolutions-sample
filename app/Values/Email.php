<?php


namespace App\Values;


use App\Values\EmailAddress;

/**
 * 이메일 클래스
 * Class SignupEmail
 * @package App\Values
 */
abstract class Email
{
    /** @var EmailAddress */
    protected $toEmail;
    /** @var EmailAddress */
    protected $fromEmail;
    /** @var string */
    protected $subject;
    /** @var string */
    protected $body;

    /**
     * @return EmailAddress
     */
    public function getToEmail(): EmailAddress
    {
        return $this->toEmail;
    }

    /**
     * @return EmailAddress
     */
    public function getFromEmail(): EmailAddress
    {
        return $this->fromEmail;
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }
}
