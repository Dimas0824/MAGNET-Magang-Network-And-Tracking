<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pekerjaan;

class PekerjaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jobs = [
            'Semua',
            'Software Engineer',
            'Data Engineer',
            'Backend Developer',
            'Frontend Developer',
            'Full Stack Developer',
            'DevOps Engineer',
            'Machine Learning Engineer',
            'Data Scientist',
            'AI Engineer',
            'Mobile App Developer',
            'Web Developer',
            'UI/UX Designer',
            'Cloud Architect',
            'Cybersecurity Analyst',
            'IT Support Specialist',
            'Network Engineer',
            'Systems Administrator',
            'Database Administrator',
            'Product Manager',
            'QA Engineer'
        ];

        foreach ($jobs as $job) {
            Pekerjaan::create([
                'nama' => $job
            ]);
        }
    }
}
