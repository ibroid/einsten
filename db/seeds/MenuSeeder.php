<?php


use Phinx\Seed\AbstractSeed;

class MenuSeeder extends AbstractSeed
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
        $posts = $this->table('menu');
        $posts->insert([
            [
                "id" => 1,
                "menu_name" => "Instrumen Sidang",
                "link" => "/instrumen_sidang",
                "is_sub" => "has-sub",
                "icon" => "bi bi-book-half"
            ],
            [
                "id" => 2,
                "menu_name" => "Instrumen Panggilan",
                "link" => "/instrumen_sidang",
                "is_sub" => "has-sub",
                "icon" => "bi bi-book-half"
            ],
            [
                "id" => 3,
                "menu_name" => "Delegasi",
                "link" => "/delegasi",
                "is_sub" => "has-sub",
                "icon" => "bi bi-box-seam"
            ],
            [
                "id" => 4,
                "menu_name" => "Keuangan",
                "link" => "/keuangan",
                "is_sub" => "has-sub",
                "icon" => "bi bi-cash-coin"
            ],
            [
                "id" => 5,
                "menu_name" => "Persidangan",
                "link" => "/persidangan",
                "is_sub" => "has-sub",
                "icon" => "bi bi-calendar2-week"
            ],
            [
                "id" => 6,
                "menu_name" => "Pencairan",
                "link" => "/pencairan",
                "is_sub" => "has-sub",
                "icon" => "bi bi-cash-coin"
            ],
        ])
            ->saveData();
    }
}
