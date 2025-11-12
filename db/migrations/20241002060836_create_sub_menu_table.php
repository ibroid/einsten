<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateSubMenuTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        $table = $this->table("sub_menu");
        $table->addColumn("sub_menu_name", "string")
            ->addColumn("menu_id", "integer")
            ->addColumn("link", "string")
            ->addColumn("created_at", "timestamp")
            ->addColumn("updated_at", "timestamp")
            ->create();
    }
}
