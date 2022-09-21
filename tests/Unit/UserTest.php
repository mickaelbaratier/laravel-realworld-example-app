<?php

namespace Tests\Unit;


use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Testing\RefreshDatabase;
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

    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('migrate');
        Artisan::call('db:seed');
    }
    //function tearDown() { $this->db->exec("ROLLBACK"); }
    public function test_getRouteKeyNames()
    {
        $user = new User();
        assertEquals('username', $user->getRouteKeyName());
    }


    public function test_articles()
    {
        $user = User::all()->firstWhere("email", "musonda@mail.com");
        $articles_expected = Article::all()->where("user_id", $user->id);
        $articles_expected = array_values($articles_expected->toArray());

        $this->assertInstanceOf(Collection::class, $user->articles);
        $this->assertCount(2, $user->articles);
        $this->assertInstanceOf(Article::class, $user->articles->first());
        $this->assertInstanceOf(Article::class, $user->articles()->first());
        $this->assertInstanceOf(HasMany::class, $user->articles());
        $this->assertEquals(["id", "user_id", "title", "slug", "description", "body", "created_at", "updated_at"], array_keys($user->articles->first()->toArray()));
        $this->assertEquals($articles_expected, $user->articles->toArray());    }

    public function test_favouriteArticles()
    {
        $user = User::all()->firstWhere("email", "rose@mail.com");
//        var_dump($user);
//        $this->assertCount(1, $user);
        $this->assertEquals(["id", "user_id", "title", "slug", "description", "body", "created_at", "updated_at"], array_keys($user->articles->first()->toArray()));
    }

    public function test_followers(){
        $user = User::all()->firstWhere("email", "rose@mail.com");

        //var_dump($user->followers->toArray());

        $this->assertInstanceOf(Collection::class, $user->followers);
        $this->assertCount(1, $user->followers);
        $this->assertInstanceOf(User::class, $user->followers->first());
        $this->assertInstanceOf(User::class, $user->followers()->first());
        $this->assertInstanceOf(BelongsToMany::class, $user->followers());
        $this->assertEquals(["username", "email", "bio"], array_keys($user->followers->first()->toArray()));
    }

    public function test_doesUserFollowAnotherUser(){
        $user1 = User::all()->firstWhere("email", "rose@mail.com");
        $user2 = User::all()->firstWhere("email", "musonda@mail.com");
//        var_dump($user1->doesUserFollowAnotherUser($user1->id, $user2->id));

        $this->assertIsBool($user1->doesUserFollowAnotherUser($user1->id, $user2->id));
        $this->assertTrue($user1->doesUserFollowAnotherUser($user1->id, $user2->id));
    }
}
