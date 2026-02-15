<?php

namespace Mgahed\LaravelStarter\Database\Seeders;

use Illuminate\Database\Seeder;
use Mgahed\LaravelStarter\Models\Admin\ContentPage;

class ContentPagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
            [
                'slug' => 'about-us',
                'version' => '1.0.0',
                'title' => [
                    'en' => 'About Us',
                    'ar' => 'من نحن',
                ],
                'content' => [
                    'en' => 'Welcome to our company. We are dedicated to providing excellent services to our customers. Our team of professionals works tirelessly to ensure your satisfaction.',
                    'ar' => 'مرحبا بكم في شركتنا. نحن ملتزمون بتقديم خدمات ممتازة لعملائنا. يعمل فريقنا من المحترفين بلا كلل لضمان رضاكم.',
                ],
                'is_published' => true,
                'record_order' => 1,
                'published_at' => now(),
            ],
            [
                'slug' => 'privacy-policy',
                'version' => '2.0.0',
                'title' => [
                    'en' => 'Privacy Policy',
                    'ar' => 'سياسة الخصوصية',
                ],
                'content' => [
                    'en' => 'Your privacy is important to us. This privacy policy explains how we collect, use, and protect your personal information.',
                    'ar' => 'خصوصيتك مهمة بالنسبة لنا. توضح سياسة الخصوصية هذه كيفية جمع معلوماتك الشخصية واستخدامها وحمايتها.',
                ],
                'is_published' => true,
                'record_order' => 2,
                'published_at' => now(),
            ],
            [
                'slug' => 'terms-and-conditions',
                'version' => '1.5.0',
                'title' => [
                    'en' => 'Terms and Conditions',
                    'ar' => 'الشروط والأحكام',
                ],
                'content' => [
                    'en' => 'By accessing our website, you agree to be bound by these terms and conditions. Please read them carefully before using our services.',
                    'ar' => 'من خلال الوصول إلى موقعنا الإلكتروني، فإنك توافق على الالتزام بهذه الشروط والأحكام. يرجى قراءتها بعناية قبل استخدام خدماتنا.',
                ],
                'is_published' => true,
                'record_order' => 3,
                'published_at' => now(),
            ],
            [
                'slug' => 'contact-us',
                'version' => '1.0.0',
                'title' => [
                    'en' => 'Contact Us',
                    'ar' => 'اتصل بنا',
                ],
                'content' => [
                    'en' => 'Have questions? We\'d love to hear from you. Send us a message and we\'ll respond as soon as possible.',
                    'ar' => 'لديك أسئلة؟ نحن نحب أن نسمع منك. أرسل لنا رسالة وسنرد في أقرب وقت ممكن.',
                ],
                'is_published' => true,
                'record_order' => 4,
                'published_at' => now(),
            ],
            [
                'slug' => 'draft-page',
                'version' => '0.1.0',
                'title' => [
                    'en' => 'Draft Page (Not Published)',
                    'ar' => 'صفحة مسودة (غير منشورة)',
                ],
                'content' => [
                    'en' => 'This is a draft page that is not yet published. It will not appear on the public website.',
                    'ar' => 'هذه صفحة مسودة لم يتم نشرها بعد. لن تظهر على الموقع العام.',
                ],
                'is_published' => false,
                'record_order' => 100,
                'published_at' => null,
            ],
        ];

        foreach ($pages as $pageData) {
            ContentPage::updateOrCreate(
                ['slug' => $pageData['slug']],
                $pageData
            );
        }

        $this->command->info('Content pages seeded successfully!');
    }
}

