<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Post;
use App\Models\Category;
use App\Models\State;
use App\Models\Admin;
use Illuminate\Support\Str;

echo "Adding Sample Job Posts...\n\n";

// Get admin user
$admin = Admin::first();
if (!$admin) {
    echo "❌ No admin user found. Please create an admin user first.\n";
    exit(1);
}

// Get categories and states
$banking = Category::where('slug', 'banking')->first();
$railways = Category::where('slug', 'railways')->first();
$ssc = Category::where('slug', 'ssc')->first();
$upsc = Category::where('slug', 'upsc')->first();
$defence = Category::where('slug', 'defence')->first();

$allIndia = State::where('slug', 'all-india')->first();
$maharashtra = State::where('slug', 'maharashtra')->first();
$delhi = State::where('slug', 'delhi')->first();
$karnataka = State::where('slug', 'karnataka')->first();

// Sample Posts
$posts = [
    [
        'title' => 'SBI Clerk Recruitment 2026 - 5000 Posts',
        'type' => 'job',
        'category_id' => $banking->id,
        'state_id' => $allIndia->id,
        'short_description' => 'State Bank of India invites applications for recruitment of Junior Associates (Customer Support & Sales) in Clerical Cadre. Total 5000 vacancies available across India.',
        'content' => '<h2>SBI Clerk Recruitment 2026</h2>
<p>State Bank of India (SBI) has released notification for recruitment of Junior Associates (Customer Support & Sales) in Clerical Cadre. This is a great opportunity for candidates looking for banking jobs.</p>

<h3>Important Dates</h3>
<ul>
<li>Online Application Start: 15th March 2026</li>
<li>Last Date to Apply: 15th April 2026</li>
<li>Preliminary Exam Date: May 2026</li>
<li>Main Exam Date: June 2026</li>
</ul>

<h3>Vacancy Details</h3>
<p>Total Posts: 5000</p>
<ul>
<li>General: 2500 Posts</li>
<li>OBC: 1350 Posts</li>
<li>SC: 750 Posts</li>
<li>ST: 400 Posts</li>
</ul>

<h3>Eligibility Criteria</h3>
<p><strong>Educational Qualification:</strong> Graduation in any discipline from a recognized University or any equivalent qualification recognized as such by the Central Government.</p>
<p><strong>Age Limit:</strong> 20-28 years as on 01.03.2026</p>

<h3>Selection Process</h3>
<ol>
<li>Preliminary Examination</li>
<li>Main Examination</li>
<li>Language Proficiency Test</li>
</ol>

<h3>Application Fee</h3>
<ul>
<li>General/OBC: Rs. 750/-</li>
<li>SC/ST/PWD: Rs. 125/-</li>
</ul>

<h3>Salary</h3>
<p>Rs. 19,900 - 63,200/- (Pay Scale)</p>',
        'total_posts' => 5000,
        'last_date' => '2026-04-15',
        'notification_date' => '2026-03-15',
        'important_links' => json_encode([
            ['label' => 'Official Notification', 'url' => 'https://sbi.co.in/careers'],
            ['label' => 'Apply Online', 'url' => 'https://sbi.co.in/apply'],
            ['label' => 'Syllabus PDF', 'url' => 'https://sbi.co.in/syllabus']
        ]),
        'meta_title' => 'SBI Clerk Recruitment 2026 - 5000 Posts Apply Online',
        'meta_description' => 'SBI Clerk Recruitment 2026: Apply online for 5000 Junior Associate posts. Check eligibility, exam dates, syllabus, and application process.',
        'meta_keywords' => 'SBI Clerk, SBI Recruitment 2026, Banking Jobs, Junior Associate',
        'is_featured' => true,
        'is_published' => true,
    ],
    [
        'title' => 'Railway Recruitment 2026 - 10000 Group D Posts',
        'type' => 'job',
        'category_id' => $railways->id,
        'state_id' => $allIndia->id,
        'short_description' => 'Railway Recruitment Board (RRB) invites applications for Group D posts. Total 10000 vacancies in various zones across India.',
        'content' => '<h2>RRB Group D Recruitment 2026</h2>
<p>Railway Recruitment Board has announced recruitment for Group D posts across all zones. This is one of the largest railway recruitments of the year.</p>

<h3>Important Dates</h3>
<ul>
<li>Notification Date: 10th March 2026</li>
<li>Application Start: 20th March 2026</li>
<li>Last Date: 20th April 2026</li>
<li>Exam Date: June 2026</li>
</ul>

<h3>Post Details</h3>
<p>Total Vacancies: 10000</p>
<ul>
<li>Track Maintainer Grade-IV: 4000</li>
<li>Helper/Assistant: 3000</li>
<li>Porter: 2000</li>
<li>Others: 1000</li>
</ul>

<h3>Eligibility</h3>
<p><strong>Education:</strong> 10th Pass or ITI</p>
<p><strong>Age:</strong> 18-33 years</p>

<h3>Salary</h3>
<p>Level 1: Rs. 18,000 - 56,900/-</p>',
        'total_posts' => 10000,
        'last_date' => '2026-04-20',
        'notification_date' => '2026-03-10',
        'important_links' => json_encode([
            ['label' => 'Official Website', 'url' => 'https://rrbcdg.gov.in'],
            ['label' => 'Apply Online', 'url' => 'https://rrbcdg.gov.in/apply']
        ]),
        'is_featured' => true,
        'is_published' => true,
    ],
    [
        'title' => 'SSC CGL 2026 Notification Released',
        'type' => 'job',
        'category_id' => $ssc->id,
        'state_id' => $allIndia->id,
        'short_description' => 'Staff Selection Commission has released notification for Combined Graduate Level Examination 2026. Apply online for various Group B and C posts.',
        'content' => '<h2>SSC CGL 2026</h2>
<p>Staff Selection Commission (SSC) has released the much-awaited notification for Combined Graduate Level Examination 2026.</p>

<h3>Important Dates</h3>
<ul>
<li>Application Start: 1st April 2026</li>
<li>Last Date: 30th April 2026</li>
<li>Tier-I Exam: July 2026</li>
</ul>

<h3>Posts</h3>
<ul>
<li>Assistant Section Officer</li>
<li>Inspector (Central Excise)</li>
<li>Inspector (Preventive Officer)</li>
<li>Tax Assistant</li>
<li>Junior Statistical Officer</li>
</ul>

<h3>Eligibility</h3>
<p><strong>Education:</strong> Bachelor\'s Degree</p>
<p><strong>Age:</strong> 18-32 years</p>',
        'last_date' => '2026-04-30',
        'notification_date' => '2026-04-01',
        'is_published' => true,
    ],
    [
        'title' => 'UPSC Civil Services Exam 2026 - IAS/IPS/IFS',
        'type' => 'job',
        'category_id' => $upsc->id,
        'state_id' => $allIndia->id,
        'short_description' => 'Union Public Service Commission invites applications for Civil Services Examination 2026 for recruitment to IAS, IPS, IFS and other services.',
        'content' => '<h2>UPSC CSE 2026</h2>
<p>UPSC has announced the Civil Services Examination 2026 for recruitment to various All India Services and Central Services.</p>

<h3>Important Dates</h3>
<ul>
<li>Notification: 5th February 2026</li>
<li>Application Start: 10th February 2026</li>
<li>Last Date: 10th March 2026</li>
<li>Preliminary Exam: 31st May 2026</li>
<li>Main Exam: September 2026</li>
<li>Interview: February 2027</li>
</ul>

<h3>Services</h3>
<ul>
<li>Indian Administrative Service (IAS)</li>
<li>Indian Police Service (IPS)</li>
<li>Indian Foreign Service (IFS)</li>
<li>Indian Revenue Service (IRS)</li>
<li>And 20+ other services</li>
</ul>

<h3>Eligibility</h3>
<p><strong>Education:</strong> Bachelor\'s Degree in any discipline</p>
<p><strong>Age:</strong> 21-32 years (General)</p>
<p><strong>Attempts:</strong> 6 attempts for General category</p>',
        'last_date' => '2026-03-10',
        'notification_date' => '2026-02-05',
        'is_featured' => true,
        'is_published' => true,
    ],
    [
        'title' => 'Indian Army Agniveer Recruitment 2026',
        'type' => 'job',
        'category_id' => $defence->id,
        'state_id' => $allIndia->id,
        'short_description' => 'Indian Army invites applications for Agniveer recruitment. Join Indian Army as Agniveer in various trades.',
        'content' => '<h2>Indian Army Agniveer 2026</h2>
<p>Indian Army is recruiting Agniveers for a 4-year tenure in various technical and non-technical trades.</p>

<h3>Important Dates</h3>
<ul>
<li>Online Registration: 1st March 2026</li>
<li>Last Date: 31st March 2026</li>
<li>Physical Test: April-May 2026</li>
</ul>

<h3>Eligibility</h3>
<p><strong>Education:</strong> 10th/12th Pass</p>
<p><strong>Age:</strong> 17.5 to 21 years</p>
<p><strong>Height:</strong> 160 cm minimum</p>

<h3>Selection Process</h3>
<ol>
<li>Physical Fitness Test</li>
<li>Physical Measurement Test</li>
<li>Medical Examination</li>
<li>Written Examination</li>
</ol>',
        'last_date' => '2026-03-31',
        'notification_date' => '2026-03-01',
        'is_published' => true,
    ],
];

echo "Creating sample posts:\n";
foreach ($posts as $postData) {
    $postData['slug'] = Str::slug($postData['title']);
    $postData['admin_id'] = $admin->id;
    
    $post = Post::create($postData);
    echo "  ✓ {$postData['title']}\n";
}

echo "\n✅ Successfully created " . count($posts) . " sample posts!\n";
echo "\nYou can now:\n";
echo "  1. Visit the public website to see the posts\n";
echo "  2. Edit posts in the admin panel\n";
echo "  3. Create more posts based on these examples\n";
