<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateRadiusTable extends AbstractMigration
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
        $table = $this->table("radius");
        $table->addColumn("kode_satker", "string");
        $table->addColumn("nama_provinsi", "string");
        $table->addColumn("kabupaten_kota", "string");
        $table->addColumn("kelurahan", "string");
        $table->addColumn("kecamatan", "string");
        $table->addColumn("kode_provinsi", "string");
        $table->addColumn("nama_satker", "string");
        $table->addColumn("biaya", "string");
        $table->addColumn("nomor_radius", "string");
        $table->addColumn("created_at", "timestamp");
        $table->addColumn("updated_at", "timestamp");
        $table->create();
    }
}
