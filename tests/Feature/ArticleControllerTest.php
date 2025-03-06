<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticleControllerTest extends TestCase
{
    // 테스트 데이터베이스 전체 삭제
    use RefreshDatabase;

    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /**
     * @test
    */
    public function 글쓰기_화면(): void
    {
        $this->actingAs($this->user)
            ->get(route('articles.create'))
            ->assertStatus(200)
            ->assertSee('글 쓰기');
    }

    /**
     * @test
    */
    public function 글저장_프로세스(): void
    {
        $testData = [
            'body' => 'test article'
        ];

        // 1. 글 저장 되는지 확인 -> 리다이렉트 까지 되는지
        $this->actingAs($this->user)
            ->post(route('articles.store'), $testData)
            ->assertRedirect(route('articles.index'));

        // 2. 저장 된 데이터 확인
        $this->assertDatabaseHas('articles', $testData);
    }

    /**
     * @test
    */
    public function 글목록_화면(): void
    {
        // 더미데이터가 바로 만들어지기때문에 속도 제한을 위한 코드
        $now = Carbon::now();
        $afterOneSecond = (clone $now)->addSecond();

        $article1 = Article::factory()->create(
            ['created_at' => $now]
        );
        $article2 = Article::factory()->create(
            ['created_at' => $afterOneSecond]
        );

        // 글 목록에서 정렬 기준으로 잘 나오는지 확인
        $this->actingAs($this->user)->get(route('articles.index'))
            ->assertSee($article1->body)
            ->assertSee($article2->body)
            ->assertSeeInOrder([
                $article2->body,
                $article1->body
            ]);
    }

    /**
     * @test
    */
    public function 개별_글_화면(): void
    {
        $article = Article::factory()->create();
        $this->actingAs($this->user)
            ->get(route('articles.show', [
                'article' => $article
            ]))
            ->assertSuccessful()
            ->assertSee($article->body);

    }

    /**
     * @test
     */
    public function 글수정_화면(): void
    {
        $article = Article::factory()->create();
        $this->actingAs($this->user)
            ->get(route('articles.edit', ['article' => $article]))
            ->assertStatus(200)
            ->assertSee('글 수정');
    }

    /**
     * @test
    */
    public function 글수정_프로세스(): void
    {
        $testData = ['body' => '수정된 글'];
        $article = Article::factory()->create();
        $this->actingAs($this->user)
            ->put(route('articles.update', ['article' => $article]), $testData)
            ->assertRedirect(route('articles.show', ['article' => $article]));

        // 데이터베이스에서 바뀐 데이터 확인
        $this->assertDatabaseHas('articles', $testData);

        // 데이터 비교 방법
        $this->assertEquals($testData['body'], $article->refresh()->body);
    }

    /**
     * @test
    */
    public function 글삭제_프로세스(): void
    {
        $articles = Article::factory()->create();
        $this->actingAs($this->user)
            ->delete(route('articles.delete', ['article' => $articles]))
            ->assertRedirect(route('articles.index'));

        // 데이터베이스에 생성된 아이디가 없는지
        $this->assertDatabaseMissing('articles', ['id' => $articles->id]);
    }
}
