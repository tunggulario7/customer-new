<?php

declare(strict_types=1);

namespace App\Models;

use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Factory;
use Respect\Validation\Validator as V;

class CustomerModel
{

    private string $name;
    private int $ktp;
    private string $loanAmount;
    private int $loanPeriod;
    private string $loanPurpose;
    private string $dateOfBirth;
    private string $sex;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName($name): void
    {
        $this->name = $name;
    }

    public function getKtp(): int
    {
        return $this->ktp;
    }

    public function setKtp($ktp): void
    {
        $this->ktp = $ktp;
    }

    public function getLoanAmount(): string
    {
        return $this->loanAmount;
    }

    public function setLoanAmount($loanAmount): void
    {
        $this->loanAmount = $loanAmount;
    }

    public function getLoanPeriod(): int
    {
        return $this->loanPeriod;
    }

    public function setLoanPeriod($loanPeriod): void
    {
        $this->loanPeriod = $loanPeriod;
    }

    public function getLoanPurpose(): string
    {
        return $this->loanPurpose;
    }

    public function setLoanPurpose($loanPurpose): void
    {
        $this->loanPurpose = $loanPurpose;
    }

    public function getDateOfBirth(): string
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth($dateOfBirth): void
    {
        $this->dateOfBirth = $dateOfBirth;
    }

    public function getSex(): string
    {
        return $this->sex;
    }

    public function setSex($sex): void
    {
        $this->sex = $sex;
    }

    /**
     * Function for validation request
     * @param $request
     * @return array|mixed
     */
    public function validate($request)
    {
        Factory::setDefaultInstance(
            (new Factory())
                ->withRuleNamespace('App\\Validation\\Rules')
                ->withExceptionNamespace('App\\Validation\\Exceptions')
        );

        $this->setName($request['name']);
        $this->setKtp($request['ktp']);
        $this->setLoanAmount($request['loanAmount']);
        $this->setLoanPeriod($request['loanPeriod']);
        $this->setLoanPurpose($request['loanPurpose']);
        $this->setDateOfBirth($request['dateOfBirth']);
        $this->setSex($request['sex']);

        $customerValidator = v::attribute('name', v::alpha(' '))
            ->attribute('ktp', v::KtpRule($this->getDateOfBirth(), $this->getSex()))
            ->attribute('loanAmount', v::number()->between(1000, 10000))
            ->attribute('loanPeriod', v::number()->between(1, 12))
            ->attribute('loanPurpose', v::in(['vacation', 'renovation', 'electronics', 'wedding', 'rent', 'car', 'investment']))
            ->attribute('dateOfBirth', v::date())
            ->attribute('sex', v::in(['M', 'F']));

        $errorMessage = [];
        try {
            $customerValidator->assert($this);
        } catch (NestedValidationException $ex) {
            $messages = $ex->getMessages();
            foreach ($messages as $message) {
                $errorMessage[] = $message;
            }
        }
        return $errorMessage;
    }
}
