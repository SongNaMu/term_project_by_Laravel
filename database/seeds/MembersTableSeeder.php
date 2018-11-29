<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MembersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */


    public function run()
    {
        // 사용자 4명 등록

        $id = ['song','kim','lim','lee'];
        $name = ['송주헌','김덕균','임동현','이태준'];
        $password = ['1234','1234','1234','1234'];
        $i;
        for($i = 0; $i < 4; $i++ ){
          DB::table('members')->insert([
            'id' => $id[$i],
            'name' => $name[$i],
            'password' => $password[$i],
            'email' => str_random(20),
            'acc' => 1
          ]);
        }
    }
}
