<?php

namespace App\Models;

class CustomerModel
{

    private $name;
    private $ktp;
    private $loanAmount;
    private $loanPeriod;
    private $loanPurpose;
    private $dateOfBirth;
    private $sex;

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
        $this->ktp = $loanPurpose;
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
}