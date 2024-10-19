<?php


use Phinx\Seed\AbstractSeed;

class SubMenuSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run(): void
    {
        $posts = $this->table('sub_menu');
        $posts->insert([
            [
                "id" => 1,
                "menu_id" => 1,
                "link" => "/instrumen_sidang",
                "sub_menu_name" => "Buat Instrumen"
            ],
            [
                "id" => 2,
                "menu_id" => 1,
                "link" => "/instrumen_sidang/daftar",
                "sub_menu_name" => "Daftar Instrumen"
            ],
        ])
            ->saveData();
    }
}
