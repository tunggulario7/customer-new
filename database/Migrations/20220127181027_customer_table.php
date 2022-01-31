<?php

declare(strict_types=1);

use Phoenix\Exception\InvalidArgumentValueException;
use Phoenix\Migration\AbstractMigration;

final class CustomerTable extends AbstractMigration
{
    /**
     * @throws InvalidArgumentValueException
     */
    protected function up(): void
    {
        $this->table('customers')
            ->addColumn('name', 'string')
            ->addColumn('ktp', 'integer')
            ->addColumn('date_of_birth', 'date')
            ->addColumn('sex', 'string')
            ->addColumn('address', 'text')
            ->create();
    }

    protected function down(): void
    {
        $this->table('customers')
        ->drop();
    }
}
