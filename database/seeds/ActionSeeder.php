<?php

use Illuminate\Database\Seeder;
use App\Action;

class ActionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Action::truncate();
        $json = File::get("database/data/test_data.json");
        $data = json_decode($json);
        foreach ($data as $row) {
        	Action::create([
        		'id' => $row->id,
	        	'description' => $row->descr,
	        	'completed' => 0
        	]);
        }
    }
}
