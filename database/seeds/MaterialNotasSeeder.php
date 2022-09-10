<?php

use Illuminate\Database\Seeder;

class MaterialNotasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $materiais = DB::select("select * from materials");
        $i = 1;
        while($i <= count($materiais)) {
            factory(\App\MaterialNotas::class, 1)->create(['material_id' => $i]);
            $i += 1;
        }
    }
}
