<?php

namespace App\Repository;

//use App\Domain\User\Data\UserData;
use App\Factory\QueryFactory;
use DomainException;

/**
 * Repository.
 */
final class CustomerRepository
{
    private QueryFactory $queryFactory;

    /**
     * The constructor.
     *
     * @param QueryFactory $queryFactory The query factory
     */
    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
    }

    public function selectCustomer()
    {
        $query = $this->queryFactory->newSelect('customers');
        $query->select(
            [
                'name'
            ]
        );

        $row = $query->execute()->fetch('assoc');

        if (!$row) {
            throw new DomainException(sprintf('User not found'));
        }

        return $row;
    }
}
