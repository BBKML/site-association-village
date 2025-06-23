<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class ArticleTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $user;
    protected $category;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->category = Category::factory()->create();
    }

    /** @test */
    public function it_can_display_articles_list()
    {
        $articles = Article::factory()->count(3)->create([
            'category_id' => $this->category->id,
            'user_id' => $this->user->id,
        ]);

        $response = $this->get('/actualites');

        $response->assertStatus(200);
        $response->assertViewIs('frontend.news');
        $response->assertViewHas('articles');
    }

    /** @test */
    public function it_can_display_single_article()
    {
        $article = Article::factory()->create([
            'published_at' => now(),
            'category_id' => $this->category->id,
            'user_id' => $this->user->id,
        ]);

        $response = $this->get("/actualites/{$article->id}");

        $response->assertStatus(200);
        $response->assertViewIs('frontend.news-show');
        $response->assertViewHas('article', $article);
    }

    /** @test */
    public function it_requires_authentication_to_create_article()
    {
        $response = $this->get('/admin/articles/create');

        $response->assertRedirect('/login');
    }

    /** @test */
    public function authenticated_user_can_create_article()
    {
        $this->actingAs($this->user);

        $articleData = [
            'title' => 'Test Article',
            'content' => 'Test content',
            'excerpt' => 'Test excerpt',
            'category_id' => $this->category->id,
            'published_at' => now()->format('Y-m-d H:i:s'),
        ];

        $response = $this->post('/admin/articles', $articleData);

        $response->assertRedirect('/admin/articles');
        $this->assertDatabaseHas('articles', [
            'title' => 'Test Article',
        ]);
    }

    /** @test */
    public function it_validates_required_fields_for_article_creation()
    {
        $this->actingAs($this->user);

        $response = $this->post('/admin/articles', []);

        $response->assertSessionHasErrors(['title', 'content']);
    }

    /** @test */
    public function it_can_update_article()
    {
        $this->actingAs($this->user);
        $article = Article::factory()->create([
            'category_id' => $this->category->id,
            'user_id' => $this->user->id,
        ]);

        $updateData = [
            'title' => 'Updated Title',
            'content' => 'Updated content',
            'excerpt' => 'Updated excerpt',
            'category_id' => $this->category->id,
        ];

        $response = $this->put("/admin/articles/{$article->id}", $updateData);

        $response->assertRedirect('/admin/articles');
        $this->assertDatabaseHas('articles', [
            'id' => $article->id,
            'title' => 'Updated Title',
        ]);
    }

    /** @test */
    public function it_can_delete_article()
    {
        $this->actingAs($this->user);
        $article = Article::factory()->create([
            'category_id' => $this->category->id,
            'user_id' => $this->user->id,
        ]);

        $response = $this->delete("/admin/articles/{$article->id}");

        $response->assertRedirect('/admin/articles');
        $this->assertDatabaseMissing('articles', [
            'id' => $article->id,
        ]);
    }

    /** @test */
    public function it_only_shows_published_articles_on_frontend()
    {
        $publishedArticle = Article::factory()->create([
            'published_at' => now()->subDay(),
            'category_id' => $this->category->id,
            'user_id' => $this->user->id,
        ]);

        $draftArticle = Article::factory()->create([
            'published_at' => null,
            'category_id' => $this->category->id,
            'user_id' => $this->user->id,
        ]);

        $response = $this->get('/actualites');

        $response->assertStatus(200);
        $response->assertViewHas('articles', function ($articles) use ($publishedArticle, $draftArticle) {
            return $articles->contains($publishedArticle) && !$articles->contains($draftArticle);
        });
    }

    /** @test */
    public function it_paginates_articles()
    {
        Article::factory()->count(25)->create([
            'published_at' => now()->subDay(),
            'category_id' => $this->category->id,
            'user_id' => $this->user->id,
        ]);

        $response = $this->get('/actualites');

        $response->assertStatus(200);
        $response->assertViewHas('articles', function ($articles) {
            return $articles->count() <= 10; // Pagination par défaut
        });
    }
} 