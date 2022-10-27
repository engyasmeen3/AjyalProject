<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vision;

class VisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Vision::create([
            'name' => 'أجيال',
            'email' => 'Ajyal@gmail.com',
            'vision' => 'تسعى أجيال إلى بلورة مفاهيم العمل المجتمعي وفقا لرؤية تتلاءم واحتياجات المجتمع، والى نشر الوعي والإدراك لدي الفئات المستهدفة للمساهمة في عملية التنمية الحقيقية ولتعزيز وتطوير قدرات المجتمع.',
            'letter' => 'Ajyal@gmail.com',
            'address' => 'أجيال',
            'description' => 'Palestinian nongovernmental organization established in 2003 and registered at the Ministry of Interior, no.7329.',

        ]);
    }
}