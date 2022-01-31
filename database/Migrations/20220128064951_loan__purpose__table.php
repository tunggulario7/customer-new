<?php

declare(strict_types=1);

use Phoenix\Exception\InvalidArgumentValueException;
use Phoenix\Migration\AbstractMigration;

final class Loan_purpose_table extends AbstractMigration
{
    /**
     * @throws InvalidArgumentValueException
     */
    protected function up(): void
    {
        $this->table('loan_purpose')
            ->addColumn('name', 'string')
            ->create();
    }

    protected function down(): void
    {
        $this->table('loan_purpose')
            ->drop();
    }
}
