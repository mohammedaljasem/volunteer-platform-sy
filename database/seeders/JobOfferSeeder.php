<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JobOffer;
use Carbon\Carbon;

class JobOfferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear ofertas de trabajo
        $jobOffers = [
            [
                'title' => 'متطوعين لتوزيع المساعدات في مخيمات النازحين',
                'description' => 'نبحث عن متطوعين للمساعدة في توزيع المساعدات الإنسانية في مخيمات النازحين في شمال سوريا. يتضمن العمل تنظيم عمليات التوزيع، تسجيل المستفيدين، والمساعدة في نقل المواد الغذائية والإغاثية. الفترة المتوقعة للتطوع هي أسبوعين، مع إمكانية التمديد.',
                'organization_id' => 1,
                'status' => 'متاحة',
                'deadline' => Carbon::now()->addDays(30),
            ],
            [
                'title' => 'متطوعين في مجال التعليم لمدارس المخيمات',
                'description' => 'تبحث مؤسسة الأمل للعمل الإنساني عن متطوعين في مجال التعليم للعمل في مدارس المخيمات في شمال سوريا. المهام تشمل تدريس المواد الأساسية (لغة عربية، رياضيات، علوم) لطلاب المرحلة الابتدائية، والمساعدة في تنظيم الأنشطة الترفيهية للأطفال. المدة المطلوبة هي 3 أشهر.',
                'organization_id' => 2,
                'status' => 'متاحة',
                'deadline' => Carbon::now()->addDays(45),
            ],
            [
                'title' => 'أطباء متطوعين للعمل في العيادات المتنقلة',
                'description' => 'تبحث جمعية العطاء الخيرية عن أطباء متطوعين للعمل في العيادات المتنقلة التي تخدم المناطق النائية في سوريا. نحتاج بشكل خاص إلى أطباء في تخصصات الأطفال، الباطنية، والنساء والتوليد. مدة التطوع المطلوبة هي شهر واحد على الأقل.',
                'organization_id' => 3,
                'status' => 'متاحة',
                'deadline' => Carbon::now()->addDays(60),
            ],
            [
                'title' => 'متطوعين للمساعدة في إعادة تأهيل المدارس',
                'description' => 'نبحث عن متطوعين للمساعدة في مشروع إعادة تأهيل المدارس المتضررة. المهام تشمل أعمال الطلاء، الترميم البسيط، تركيب النوافذ والأبواب، وتجهيز الفصول الدراسية. نرحب بالمتطوعين ذوي الخبرة في أعمال البناء والنجارة.',
                'organization_id' => 1,
                'status' => 'قادمة',
                'deadline' => Carbon::now()->addDays(90),
            ],
            [
                'title' => 'متطوعين للعمل في مشروع الصحة النفسية',
                'description' => 'تبحث مؤسسة الأمل عن متطوعين من ذوي الخبرة في مجال الصحة النفسية والدعم النفسي والاجتماعي. سيعمل المتطوعون ضمن فريق الدعم النفسي لمساعدة الأطفال والعائلات المتضررة من الحرب. مطلوب خبرة سابقة في مجال العلاج النفسي أو الإرشاد.',
                'organization_id' => 2,
                'status' => 'مغلقة',
                'deadline' => Carbon::yesterday(),
            ],
        ];

        foreach ($jobOffers as $offer) {
            JobOffer::create($offer);
        }
    }
}
