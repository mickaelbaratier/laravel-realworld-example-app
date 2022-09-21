<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $id_Rose = DB::table('users')->insertGetId(
            [
                'username' => 'Rose',
                'email' => 'rose@mail.com',
                'password' => Hash::make('pwd'),
                'bio' => 'Je voudrais devenir enseignante pour enfants',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        $id_Musonda = DB::table('users')->insertGetId(
            [
                'username' => 'Musonda',
                'email' => 'musonda@mail.com',
                'password' => Hash::make('pwd2'),
                'bio' => 'Je songe à devenir infirmière, j’écris mes réflexions',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );

        $id_articleRose = DB::table('articles')->insertGetId(
            [
                'user_id' => $id_Rose,
                'title' => Str::random(15),
                'slug' => Str::random(15),
                'description' => Str::random(15),
                'body' => Str::random(15),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );
        $id_articleMusonda1 = DB::table('articles')->insertGetId(
            [
                'user_id' => $id_Musonda,
                'title' => Str::random(15),
                'slug' => Str::random(15),
                'description' => Str::random(15),
                'body' => Str::random(15),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );
        $id_articleMusonda2 = DB::table('articles')->insertGetId(
            [
                'user_id' => $id_Musonda,
                'title' => Str::random(15),
                'slug' => Str::random(15),
                'description' => Str::random(15),
                'body' => Str::random(15),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );

        DB::table('article_user')->insert([
                [
                    'user_id' => $id_Musonda,
                    'article_id' => $id_articleRose
                ],
                [
                    'user_id' => $id_Rose,
                    'article_id' => $id_articleMusonda1
                ],
                [
                    'user_id' => $id_Rose,
                    'article_id' => $id_articleMusonda2
                ],
            ]
        );

        $id_tag = DB::table('tags')->insertGetId(
            [
                'name' => 'education'
            ]
        );

        DB::table('article_tag')->insert(
            [
                'tag_id' => $id_tag,
                'article_id' => $id_articleRose
            ]
        );

        DB::table('comments')->insert(
            [
                'user_id' => $id_Musonda,
                'article_id' => $id_articleRose,
                'body' => Str::random(30),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );
        DB::table('followers')->insert(
            [
                [
                    'follower_id' => $id_Musonda,
                    'following_id' => $id_Rose
                ],
                [
                    'follower_id' => $id_Rose,
                    'following_id' => $id_Musonda
                ]
            ]
        );
    }
}
