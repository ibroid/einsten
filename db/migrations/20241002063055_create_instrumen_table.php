<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateInstrumenTable extends AbstractMigration
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
        $table = $this->table("instrumen");
        $table->addColumn("sidang_id", "integer")
            ->addColumn("jurusita_id", "integer")
            ->addColumn("perkara_id", "integer")
            ->addColumn("pihak_id", "integer")
            ->addColumn("biaya", "string")
            ->addColumn("jenis_panggilan", "string")
            ->addColumn("jenis_pihak", "string")
            ->addColumn("kode_panggilan", "string")
            ->addColumn("pencairan", "integer", ["length" => 1])
            ->addColumn("tanggal_dibuat", "date")
            ->addColumn("created_at", "timestamp")
            ->addColumn("updated_at", "timestamp")
            ->create();
    }
}
