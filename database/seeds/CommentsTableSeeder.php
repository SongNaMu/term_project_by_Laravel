<?php

use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
          짝수id 게시글에 댓글 10개식 달기

        */
        $id = ['song','kim','lim','lee'];

        for($j = 1; $j < 50; $j++){
          for($i = 0; $i < 10; $i++ ){
            DB::table('comments')->insert([
              'member_id' => $id[rand(0,3)],
              'board_id' => $j*2,
              'content' => str_random(20)
            ]);
          }
        }
        for($j = 1; $j < 50; $j++){
          for($i = 0; $i < 10; $i++ ){
            DB::table('comments')->insert([
              'member_id' => $id[rand(0,3)],
              'board_id' => $j*2,
              'content' => str_random(20),
              'comment_id' => rand($j*2*5-9, $j*5*2 )
            ]);
          }
        }

    }
}
