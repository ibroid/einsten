<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreatePotonganJurnalTable extends AbstractMigration
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
        $table = $this->table("potongan_jurnal");
        $table->addColumn("nama_radius", "string");
        $table->addColumn("filter_key", "string");
        $table->addColumn("jumlah_jurnal", "integer");
        $table->addColumn("jumlah_jurusita", "integer");
        $table->addColumn("jumlah_kantor", "integer");
        $table->addColumn("berlaku_dari", "date");
        $table->addColumn("berlaku_sampai", "date");
        $table->addColumn("created_at", "timestamp");
        $table->addColumn("updated_at", "timestamp");
        $table->save();
    }
}
