<?php
use Notadd\Foundation\Database\Abstracts\Seeder;
/**
 * Class DatabaseSeeder
 */
class DatabaseSeeder extends Seeder {
    /**
     * Run the database seeds.
     * @return void
     */
    public function run() {
        $this->command->getOutput()->writeln('<info>There is Nothing to seed!</info>');
    }
}