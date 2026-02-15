<?php

namespace Mgahed\LaravelStarter\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Mgahed\LaravelStarter\Models\Admin\ContentPage;

class ContentPageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_content_page()
    {
        $page = ContentPage::create([
            'title' => [
                'en' => 'Test Page',
                'ar' => 'صفحة اختبار',
            ],
            'content' => [
                'en' => 'This is test content',
                'ar' => 'هذا محتوى اختبار',
            ],
            'slug' => 'test-page',
            'version' => '1.0',
            'is_published' => true,
            'published_at' => now(),
        ]);

        $this->assertDatabaseHas('content_pages', [
            'slug' => 'test-page',
        ]);

        $this->assertEquals('Test Page', $page->getTranslation('title', 'en'));
        $this->assertEquals('صفحة اختبار', $page->getTranslation('title', 'ar'));
    }

    /** @test */
    public function it_auto_generates_slug_from_title()
    {
        $page = ContentPage::create([
            'title' => [
                'en' => 'My Awesome Page',
            ],
            'content' => [
                'en' => 'Content here',
            ],
        ]);

        $this->assertEquals('my-awesome-page', $page->slug);
    }

    /** @test */
    public function it_ensures_slug_uniqueness()
    {
        ContentPage::create([
            'title' => ['en' => 'Test'],
            'content' => ['en' => 'Content'],
            'slug' => 'test-page',
        ]);

        $page2 = ContentPage::create([
            'title' => ['en' => 'Test'],
            'content' => ['en' => 'Content'],
        ]);

        $this->assertNotEquals('test-page', $page2->slug);
        $this->assertStringStartsWith('test', $page2->slug);
    }

    /** @test */
    public function it_can_get_published_pages_only()
    {
        ContentPage::create([
            'title' => ['en' => 'Published Page'],
            'content' => ['en' => 'Content'],
            'is_published' => true,
            'published_at' => now(),
        ]);

        ContentPage::create([
            'title' => ['en' => 'Draft Page'],
            'content' => ['en' => 'Content'],
            'is_published' => false,
        ]);

        $publishedPages = ContentPage::published()->get();

        $this->assertCount(1, $publishedPages);
        $this->assertEquals('Published Page', $publishedPages->first()->getTranslation('title', 'en'));
    }

    /** @test */
    public function it_can_search_pages()
    {
        ContentPage::create([
            'title' => ['en' => 'About Us'],
            'content' => ['en' => 'Content'],
            'slug' => 'about-us',
        ]);

        ContentPage::create([
            'title' => ['en' => 'Contact'],
            'content' => ['en' => 'Content'],
            'slug' => 'contact',
        ]);

        $results = ContentPage::search('about')->get();

        $this->assertCount(1, $results);
        $this->assertEquals('about-us', $results->first()->slug);
    }

    /** @test */
    public function it_gets_available_languages()
    {
        $page = ContentPage::create([
            'title' => [
                'en' => 'Test',
                'ar' => 'اختبار',
                'fr' => 'Test',
            ],
            'content' => [
                'en' => 'Content',
                'ar' => 'محتوى',
                'fr' => 'Contenu',
            ],
        ]);

        $languages = $page->getAvailableLanguages();

        $this->assertCount(3, $languages);
        $this->assertContains('en', $languages);
        $this->assertContains('ar', $languages);
        $this->assertContains('fr', $languages);
    }

    /** @test */
    public function it_checks_translation_existence()
    {
        $page = ContentPage::create([
            'title' => [
                'en' => 'Test',
                'ar' => 'اختبار',
            ],
            'content' => [
                'en' => 'Content',
                'ar' => 'محتوى',
            ],
        ]);

        $this->assertTrue($page->hasTranslation('en'));
        $this->assertTrue($page->hasTranslation('ar'));
        $this->assertFalse($page->hasTranslation('fr'));
    }

    /** @test */
    public function it_gets_localized_content_with_fallback()
    {
        app()->setLocale('ar');

        $page = ContentPage::create([
            'title' => [
                'en' => 'Test Page',
            ],
            'content' => [
                'en' => 'Test Content',
            ],
        ]);

        $localized = $page->getLocalizedContent();

        // Should fallback to English since Arabic doesn't exist
        $this->assertEquals('Test Page', $localized['title']);
        $this->assertEquals('Test Content', $localized['content']);
    }

    /** @test */
    public function protected_pages_cannot_be_deleted()
    {
        $page = ContentPage::create([
            'title' => ['en' => 'Protected Page'],
            'content' => ['en' => 'Content'],
            'protected' => 1,
        ]);

        $this->expectException(\Exception::class);
        $page->delete();
    }
}

