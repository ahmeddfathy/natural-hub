<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'title' => 'تأليف قصص الأطفال',
                'description' => 'كتابة قصص مشوقة وتعليمية وثرية ثقافياً للأطفال بمختلف الفئات العمرية، من Early Readers حتى اليافعين.',
                'features' => [
                    'قصص تعليمية وترفيهية',
                    'مناسبة لجميع الأعمار',
                    'محتوى ثري ثقافياً',
                    'منشورة عبر دور نشر رائدة',
                ],
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'كتابة الروايات',
                'description' => 'تأليف روايات للفتيات واليافعين تتناول قضاياهم وتتحدث بلسانهم، منشورة عبر دور نشر عربية رائدة.',
                'features' => [
                    'روايات يافعين ومراهقين',
                    'قصص تتناول قضايا حقيقية',
                    'أسلوب سردي مشوق',
                    'نشر عبر دور نشر معتمدة',
                ],
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'كتابة المقالات',
                'description' => 'كتابة مقالات احترافية ومتوافقة مع SEO في مختلف المجالات، منشورة على منصات مثل خمسات وساسة بوست.',
                'features' => [
                    'متوافقة مع معايير SEO',
                    'بحث معمق ودقيق',
                    'أسلوب جذاب وسهل',
                    'تدقيق لغوي شامل',
                ],
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'كتابة السيناريوهات التعليمية',
                'description' => 'كتابة سيناريوهات تعليمية للأطفال والكبار يتم إخراجها في فيديوهات أنيميشن تُبث على منصات تعليمية.',
                'features' => [
                    'سيناريوهات أنيميشن',
                    'محتوى تعليمي متكامل',
                    'مناسبة للأطفال والكبار',
                    'جاهزة للإخراج والبث',
                ],
                'sort_order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(
                ['title' => $service['title']],
                $service
            );
        }
    }
}
