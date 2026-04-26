<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$expected = [
    'age_min', 'age_max_gen', 'age_max_obc', 'age_max_sc', 'age_max_st', 'age_max_ews', 'age_max_ph', 'age_max_ex_serviceman', 'age_relaxation_note',
    'fee_general', 'fee_obc', 'fee_sc_st', 'fee_ph', 'fee_ex_serviceman', 'fee_note',
    'vacancy_gen', 'vacancy_obc', 'vacancy_sc', 'vacancy_st', 'vacancy_ews', 'vacancy_ph', 'vacancy_ex_serviceman', 'vacancy_breakdown_note',
    'job_nature', 'salary_type', 'salary_display_label', 'post_training_pay', 'experience_years', 'experience_type',
    'exam_date', 'admit_card_date', 'result_date', 'interview_date', 'dv_date',
    'post_name', 'seo_title', 'selection_stages', 'scope', 'sub_category',
    'organisation_full', 'organisation_type', 'advt_no', 'department',
    'education_level', 'education_note', 'education_specialisation',
    'post_name_schema', 'hiring_org_schema', 'hiring_org_url', 'employment_type_schema', 'work_location_type', 'posting_location',
    'exam_mode', 'exam_type',
    'notification_pdf_url', 'apply_url', 'direct_apply', 'official_website',
    'salary_min', 'salary_max', 'salary_currency', 'salary_period',
    'qualifications', 'skills', 'responsibilities', 'faq',
    'validation_issues', 'needs_manual_review', 'ai_confidence_score'
];

$columns = \Illuminate\Support\Facades\Schema::getColumnListing('posts');
$missing = array_diff($expected, $columns);
if (empty($missing)) {
    echo "ALL COLUMNS EXIST\n";
} else {
    echo "MISSING COLUMNS: " . implode(', ', $missing) . "\n";
}
