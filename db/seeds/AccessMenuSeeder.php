<?php


use Phinx\Seed\AbstractSeed;

class AccessMenuSeeder extends AbstractSeed
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
        $posts = $this->table('access_menu');
        $posts->insert([
            [
                "menu_id" => 1,
                "group_id" => 1
            ],
            [
                "menu_id" => 1,
                "group_id" => 30
            ],
            [
                "menu_id" => 1,
                "group_id" => 500
            ],
            [
                "menu_id" => 1,
                "group_id" => 430
            ],
            [
                "menu_id" => 1,
                "group_id" => 1010
            ],
            [
                "menu_id" => 1,
                "group_id" => 1000
            ],
            [
                "menu_id" => 2,
                "group_id" => 1
            ],
            [
                "menu_id" => 3,
                "group_id" => 1
            ],
            [
                "menu_id" => 3,
                "group_id" => 650
            ],
            [
                "menu_id" => 4,
                "group_id" => 1
            ],
            [
                "menu_id" => 4,
                "group_id" => 702
            ],
            [
                "menu_id" => 6,
                "group_id" => 702
            ],
            [
                "menu_id" => 6,
                "group_id" => 1
            ],
            [
                "menu_id" => 5,
                "group_id" => 1
            ],
            [
                "menu_id" => 5,
                "group_id" => 30
            ],
            [
                "menu_id" => 5,
                "group_id" => 500
            ],
            [
                "menu_id" => 7,
                "group_id" => 600
            ],
            [
                "menu_id" => 8,
                "group_id" => 600
            ],
            [
                "menu_id" => 9,
                "group_id" => 1
            ],
            [
                "menu_id" => 9,
                "group_id" => 702
            ],
        ])
            ->saveData();
    }
}
