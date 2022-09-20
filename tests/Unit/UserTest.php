<?php

namespace Tests\Unit;


use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
//use PHPUnit\Framework\TestCase;
use Tests\TestCase;
use function PHPUnit\Framework\assertEquals;

class UserTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */

    public function test_getRouteKeyNames()
    {
        $user = new User();
        assertEquals('username', $user->getRouteKeyName());
    }

    public function test_articles()
    {
        parent::setUp();
        $article = DB::table('articles') ->where('user_id','===', 11)->get();
        var_dump($article);
        assertEquals(!NULL,$article);
    }
}
