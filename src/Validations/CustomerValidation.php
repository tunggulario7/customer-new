<?php

namespace App\Validations;

use Respect\Validation\Validator as V;
use Respect\Validation\Exceptions\NestedValidationException;
use App\Models\CustomerModel;

class CustomerValidation {

    public function validate($request) {
        $customer = new CustomerModel();
        $customer->setName($request['name']);
        $customer->setKtp($request['ktp']);
        $customer->setLoanAmount($request['loanAmount']);
        $customer->setLoanPeriod($request['loanPeriod']);
        $customer->setLoanPurpose($request['loanPurpose']);
        $customer->setDateOfBirth($request['dateOfBirth']);
        $customer->setSex($request['sex']);


        $customerValidator = v::attribute('name', v::alpha(' '))
            ->attribute('ktp', v::number())
            ->attribute('loanAmount', v::number()->between(1000, 10000))
            ->attribute('loanPeriod', v::number()->between(1, 12))
            ->attribute('loanPurpose', v::in(['vacation', 'renovation', 'electronics', 'wedding', 'rent', 'car', 'investment']))
            ->attribute('dateOfBirth', v::date())
            ->attribute('sex', v::alpha());

        try {
            $customerValidator->assert($customer);
            return $request;
        } catch(NestedValidationException $ex) {

            $messages = $ex->getMessages();

            foreach ($messages as $message) {
                echo $message . "\n";
            }
        }
    }
}