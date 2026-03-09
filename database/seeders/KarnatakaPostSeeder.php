<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\State;
use App\Models\Category;
use Illuminate\Database\Seeder;

class KarnatakaPostSeeder extends Seeder
{
    public function run(): void
    {
        $karnataka = State::where('name', 'Karnataka')->first();
        if (!$karnataka) {
            return;
        }

        $categories = Category::all();
        $categoryId = $categories->first()?->id ?? 1;

        // Jobs
        $jobs = [
            'KPSC Recruitment 2024 - 150 Posts',
            'Karnataka Police Constable Recruitment',
            'KSRTC Driver Recruitment 2024',
            'Karnataka Bank Clerk Recruitment',
            'BBMP Sanitation Worker Recruitment',
            'Karnataka Forest Guard Recruitment',
            'KSEB Junior Engineer Recruitment',
            'Karnataka PWD Recruitment 2024',
            'KSDC Recruitment - Various Posts',
            'Karnataka Postal Circle Recruitment',
        ];

        foreach ($jobs as $title) {
            Post::create([
                'title' => $title,
                'slug' => \Str::slug($title),
                'type' => 'job',
                'content' => 'Important job notification for Karnataka. Apply now for this exciting opportunity.',
                'short_description' => 'Latest job opportunity in Karnataka',
                'meta_title' => $title,
                'meta_description' => 'Apply for ' . $title,
                'meta_keywords' => 'Karnataka, jobs, recruitment',
                'state_id' => $karnataka->id,
                'category_id' => $categoryId,
                'is_published' => true,
                'view_count' => rand(100, 5000),
            ]);
        }

        // Results
        $results = [
            'KPSC Exam Result 2024 - Released',
            'Karnataka Police Constable Result',
            'KSRTC Driver Exam Result',
            'Karnataka Bank Clerk Result 2024',
            'BBMP Sanitation Worker Result',
            'Karnataka Forest Guard Result',
            'KSEB Junior Engineer Result',
            'Karnataka PWD Exam Result',
            'KSDC Recruitment Result',
            'Karnataka Postal Circle Result',
        ];

        foreach ($results as $title) {
            Post::create([
                'title' => $title,
                'slug' => \Str::slug($title),
                'type' => 'result',
                'content' => 'Exam result has been released. Check your result now.',
                'short_description' => 'Latest exam result for Karnataka',
                'meta_title' => $title,
                'meta_description' => 'Check ' . $title,
                'meta_keywords' => 'Karnataka, result, exam',
                'state_id' => $karnataka->id,
                'category_id' => $categoryId,
                'is_published' => true,
                'view_count' => rand(100, 5000),
            ]);
        }

        // Admit Cards
        $admitCards = [
            'KPSC Admit Card 2024 - Download Now',
            'Karnataka Police Constable Admit Card',
            'KSRTC Driver Admit Card Released',
            'Karnataka Bank Clerk Admit Card',
            'BBMP Sanitation Worker Admit Card',
            'Karnataka Forest Guard Admit Card',
            'KSEB Junior Engineer Admit Card',
            'Karnataka PWD Admit Card 2024',
            'KSDC Recruitment Admit Card',
            'Karnataka Postal Circle Admit Card',
        ];

        foreach ($admitCards as $title) {
            Post::create([
                'title' => $title,
                'slug' => \Str::slug($title),
                'type' => 'admit_card',
                'content' => 'Admit card has been released. Download your admit card now.',
                'short_description' => 'Admit card for Karnataka exam',
                'meta_title' => $title,
                'meta_description' => 'Download ' . $title,
                'meta_keywords' => 'Karnataka, admit card, exam',
                'state_id' => $karnataka->id,
                'category_id' => $categoryId,
                'is_published' => true,
                'view_count' => rand(100, 5000),
            ]);
        }

        // Answer Keys
        $answerKeys = [
            'KPSC Answer Key 2024 - Released',
            'Karnataka Police Constable Answer Key',
            'KSRTC Driver Answer Key',
            'Karnataka Bank Clerk Answer Key',
            'BBMP Sanitation Worker Answer Key',
            'Karnataka Forest Guard Answer Key',
            'KSEB Junior Engineer Answer Key',
            'Karnataka PWD Answer Key 2024',
            'KSDC Recruitment Answer Key',
            'Karnataka Postal Circle Answer Key',
        ];

        foreach ($answerKeys as $title) {
            Post::create([
                'title' => $title,
                'slug' => \Str::slug($title),
                'type' => 'answer_key',
                'content' => 'Official answer key has been released. Check your answers now.',
                'short_description' => 'Answer key for Karnataka exam',
                'meta_title' => $title,
                'meta_description' => 'Check ' . $title,
                'meta_keywords' => 'Karnataka, answer key, exam',
                'state_id' => $karnataka->id,
                'category_id' => $categoryId,
                'is_published' => true,
                'view_count' => rand(100, 5000),
            ]);
        }

        // Syllabus
        $syllabus = [
            'KPSC Exam Syllabus 2024',
            'Karnataka Police Constable Syllabus',
            'KSRTC Driver Exam Syllabus',
            'Karnataka Bank Clerk Syllabus',
            'BBMP Sanitation Worker Syllabus',
            'Karnataka Forest Guard Syllabus',
            'KSEB Junior Engineer Syllabus',
            'Karnataka PWD Exam Syllabus',
            'KSDC Recruitment Syllabus',
            'Karnataka Postal Circle Syllabus',
        ];

        foreach ($syllabus as $title) {
            Post::create([
                'title' => $title,
                'slug' => \Str::slug($title),
                'type' => 'syllabus',
                'content' => 'Complete syllabus for the exam. Prepare well for your exam.',
                'short_description' => 'Syllabus for Karnataka exam',
                'meta_title' => $title,
                'meta_description' => 'Download ' . $title,
                'meta_keywords' => 'Karnataka, syllabus, exam',
                'state_id' => $karnataka->id,
                'category_id' => $categoryId,
                'is_published' => true,
                'view_count' => rand(100, 5000),
            ]);
        }

        // Blogs
        $blogs = [
            'How to Prepare for KPSC Exam - Tips and Tricks',
            'Karnataka Police Constable Exam - Complete Guide',
            'KSRTC Driver Recruitment - Everything You Need to Know',
            'Karnataka Bank Clerk Exam - Preparation Strategy',
            'BBMP Recruitment - Career Opportunities',
            'Karnataka Forest Guard - Job Profile and Benefits',
            'KSEB Junior Engineer - Salary and Career Growth',
            'Karnataka PWD Recruitment - Application Process',
            'KSDC Recruitment - Interview Tips',
            'Karnataka Postal Circle - Government Job Benefits',
        ];

        foreach ($blogs as $title) {
            Post::create([
                'title' => $title,
                'slug' => \Str::slug($title),
                'type' => 'blog',
                'content' => 'Comprehensive guide and tips for preparing for Karnataka government exams.',
                'short_description' => 'Blog post about Karnataka government jobs',
                'meta_title' => $title,
                'meta_description' => 'Read ' . $title,
                'meta_keywords' => 'Karnataka, blog, government jobs',
                'state_id' => $karnataka->id,
                'category_id' => $categoryId,
                'is_published' => true,
                'view_count' => rand(100, 5000),
            ]);
        }
    }
}
