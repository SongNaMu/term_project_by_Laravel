<?php

use Illuminate\Database\Seeder;

class BoardsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //랜덤사용자로 글 100개 쓰기

        $member_id = ['song', 'kim','lim', 'lee'];

        for($i = 0; $i < 50; $i++ ){
          DB::table('boards')->insert([
            'member_id' => $member_id[rand(0,3)],
            'title' => str_random(7),
            'content' => str_random(20)
          ]);
        }

    }
}
