<?php
/**
 * delete_indexed_posts.php
 * Run via SSH on the live server:
 *   php delete_indexed_posts.php
 *   php delete_indexed_posts.php --dry-run   (preview only, no deletion)
 *   php delete_indexed_posts.php --confirm   (actually delete)
 *
 * Place this file in the Laravel root, then remove after use.
 */

define('LARAVEL_START', microtime(true));
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

// ── slugs extracted from the URLs the user provided ──────────────────────────
$slugs = [
    // /job/ slugs
    'uttrakhand-subordinate-service-selection-commission-uksssc-102-group-c-various-post-recruitment-2023-result-for-236-post',
    'upsssc-vidhan-bhawan-guard-recruitment-2026',
    'ncl-operator-trainee-paramedical-staff-and-overseer-recruitment-for-577-posts',
    'ssc-102-chsl-recruitment-2022-final-result-for-4500-post',
    'rajasthan-food-safety-officer-fso-recruitment-2022-apply-online-for-200-post',
    'nvs-teacher-recruitment-2026-apply-online-for-208-staff-nurse-tgt-pgt-and-more-posts',
    'hp-home-guards-home-guard-volunteers-700-posts',
    'ssc-constable-gd-in-central-armed-police-forces-capfs-and-ssf-and-rifleman-gd-in-assam-rifles-examination-2026-exam-postponed-for-25487-post',
    'gsssb-wireman-1-posts',
    'csbc-bihar-police-constable-operator-online-form-2026',
    'central-bank-of-india-specialist-officers-275-posts',
    'western-railway-rrc-mumbai-various-trade-apprentices-2024-apply-online-for-5066-post',
    'jharkhand-police-sub-inspector-recruitment-final-result-with-marks-2017',
    'bel-deputy-engineer-35-posts',
    'ssc-kkr-recruitment-2026-young-professional-jobs',
    'upsc-epfo-enforcement-account-officer-recruitment-interview-list-2017',
    'uksssc-personal-assistant-stenographer-aps-recruitment-2024-download-admit-card-for-257-post',
    'powergrid-non-executive-recruitment-2026',
    'rajasthan-housing-board-rhb-recruitment-2023-result-for-various-258-post',
    'ssc-combined-graduate-level-cgl-exam-2022-final-result',
    'hbchrc-visakhapatnam-technician-2-posts',
    'ordnance-factory-chanda-dbw-recruitment-2026',
    'bobcaps-business-development-manager-103-posts',
    'rajasthan-high-court-clerk-various-post-result-computer-test-admit-card-2022',
    'rajasthan-rpsc-assistant-professor-college-education-admit-card-2021',
    'irctc-recruitment-2026-walk-in-interview-for-84-hospitality-monitor-posts',
    'icsil-recruitment-2026-apply-online-for-40-deo-and-mts-posts',
    'ncr-indian-railway-rrc-prayagraj-various-trade-apprentices-2024-apply-online-for-1697-post',
    'mgu-associate-professor-1-posts',
    'ssc-sub-inspector-in-delhi-police-and-central-armed-police-forces-examination-cpo-si-2024-download-paper-i-result-with-marks-revised-pet-pst-revised-results-paper-ii-answer-key-for-4187-post',
    'indian-bank-so-vacancy-2026-for-350-post-link-active-apply-fast',
    'iari-recruitment-2026-apply-now-for-young-professional-posts',
    'assam-cooperative-apex-bank-assistant-150-posts',
    'iiser-pune-research-associate-2-posts',
    'nmpa-recruitment-2026-apply-online-for-various-posts',
    'rrc-cr-apprentices-online-form-2026',
    'bihar-iti-cat-admission-form-2026-online-application',
    'railway-rail-wheel-factory-rwf-various-trade-apprentices-2025-apply-online-for-192-post',
    'central-bank-of-india-so-recruitment-2026-apply-online-for-26-specialist-officers-posts',
    'hprca-pgt-teacher-recruitment-2026-apply-online-for-390-posts',
    'nhpc-apprentice-recruitment-2026-graduate-diploma-iti-online-form-2026',
    'itbp-assistant-commandant-recruitment-2026-apply-online',
    'iit-roorkee-junior-research-fellow-1-posts',
    'bavmc-pune-tutor-junior-resident-34-posts',
    'rpsc-head-master-recruitment-2021-admit-card-for-83-post',
    'bihar-btsc-instructor-recruitment-2026',
    'iitm-research-fellow-20-posts',
    'idbi-bank-assistant-manager-200-posts',
    'upsssc-havaldar-instructor-recruitment-2026',
    'dwcweo-bapatla-district-coordinator-1-posts',
    'uttrakhand-uksssc-cartographer-and-surveyor-online-form-2021',
    'rajasthan-rpsc-junior-legal-officer-jlo-recruitment-2023-result-for-140-post',
    'indian-railway-northern-region-rrc-delhi-act-apprentices-notification-2023-2024-cutoff-and-status-for-3093-post',
    'mahatransco-apprentice-50-posts',
    'nia-recruitment-2026-apply-offline-for-29-assistant-ldc-posts',
    'ssc-102-head-constable-ministerial-in-delhi-police-recruitment-2022-exam-final-result-with-detailed-marks-2023',
    'indian-army-agniveer-cee-recruitment-2026-secure-your-future-with-jobonein',
    'rajasthan-rpsc-assistant-electrical-inspector-recruitment-2025-apply-online-for-09-post',
    'uksssc-vdo-aro-patwari-lekhpal-and-other-various-post-recruitment-2025-apply-online-for-419-post',
    'rajasthan-hc-group-d-online-form',
    'railway-rrb-assistant-loco-pilot-alp-cen-012026-online-form',
    'ssb-constable-tradesman-recruitment-2026-apply-online-for-827-posts-at-ssbgovin',
    'btsc-laboratory-assistant-recruitment-2026',
    'ssc-combined-graduate-level-cgl-exam-2023-final-revised-result-for-8440-post',
    'wcd-kalaburagi-recruitment-2026-apply-online-for-anganwadi-posts',
    'bpcl-recruitment-2026-without-gate-apply-online',
    'upsssc-group-c-recruitment-2026-notification',
    'upsssc-pet-2023-certificate',
    'ssb-odisha-librarian-recruitment-2026-notification',
    'rajasthan-rpsc-agriculture-officer-recruitment-2024-apply-online-for-25-post',
    'rajasthan-hc-translator-admit-card-2020',
    'ssb-constable-tradesman-recruitment-2026',
    'bpsc-school-teacher-tre-40-recruitment-2026-out-for-44000-posts',
    'bihar-btsc-instructor-recruitment-2026-apply-online',
    'gbpuat-research-associate-i-1-posts',
    'bel-machilipatnam-apprentices-recruitment-2026',
    'public-health-department-maharashtra-medical-officer-1440-posts',
    'uttarakhand-police-head-constable-online-form-2022',
    'mpesb-van-rakshak-jail-prahari-recruitment-2026',
    'central-railway-rrc-cr-apprentice-online-form-2022',
    'bmc-medical-officer-mbbs-1-posts',
    'nic-scientist-recruitment-2026-notification-out-apply-online-for-153-scientist-d-scientist-c-posts',

    // /result/ slugs
    'ibps-rrb-14th-office-assistant-mains-result-2026',
    'india-post-gds-result-first-merit-list-2026',
    'delhi-dda-mts-result-2026-out',

    // /admit_card/ slugs
    'bihar-special-school-teacher-final-answer-key-2026',
    'ssc-gd-constable-exam-date-2026-out-jobonein',
    'bihar-vidhan-parishad-security-guard-physical-admit-card-2026-exam',

    // /answer_key/ slugs
    'rrb-ntpc-graduate-level-answer-key-2026-out-today-download-pdf-response-sheet',
    'bihar-bpsc-aso-vacancy-2025-bihar-bpsc-aso-recruitment',

    // /blog/ slugs
    'free-sewing-machine-scheme-2026-karnataka-dbcdc-women',
];

// ── URLs that are NOT individual posts (skip these) ───────────────────────────
// jobone.in/state/telangana, jobone.in/state/karnataka, jobone.in/state/uttar-pradesh,
// jobone.in/state/assam, jobone.in/state/punjab, jobone.in/jobs, jobone.in/,
// jobone.in/all-posts  → These are listing/state pages, not individual posts.

$dryRun = !in_array('--confirm', $argv ?? []);

echo "=== JobOne.in Indexed Posts Deletion Script ===\n";
echo "Mode: " . ($dryRun ? "DRY RUN (no changes) – pass --confirm to delete" : "LIVE DELETE") . "\n";
echo "Total slugs targeted: " . count($slugs) . "\n\n";

// ── Query posts matching these slugs ─────────────────────────────────────────
$found = DB::table('posts')
    ->whereIn('slug', $slugs)
    ->get(['id', 'slug', 'type', 'title', 'is_published']);

echo "Found in DB: " . count($found) . " records\n\n";

if ($found->isEmpty()) {
    echo "No matching records found. Nothing to delete.\n";
    exit(0);
}

// Print a preview table
printf("%-6s %-12s %-10s %-8s %s\n", "ID", "Type", "Published", "Slug", "Title (truncated)");
echo str_repeat("-", 100) . "\n";
foreach ($found as $post) {
    printf(
        "%-6d %-12s %-10s %-50s %s\n",
        $post->id,
        $post->type,
        $post->is_published ? 'YES' : 'NO',
        substr($post->slug, 0, 48),
        substr($post->title ?? '', 0, 40)
    );
}

echo "\n";

// ── Also detect slugs NOT found in DB ────────────────────────────────────────
$foundSlugs = $found->pluck('slug')->toArray();
$notFound   = array_diff($slugs, $foundSlugs);
if (!empty($notFound)) {
    echo "⚠  " . count($notFound) . " slug(s) NOT found in DB (already deleted or never imported):\n";
    foreach ($notFound as $s) {
        echo "   - $s\n";
    }
    echo "\n";
}

// ── Delete ────────────────────────────────────────────────────────────────────
if (!$dryRun) {
    $ids = $found->pluck('id')->toArray();

    DB::beginTransaction();
    try {
        $deleted = DB::table('posts')->whereIn('id', $ids)->delete();
        DB::commit();
        echo "✅ Successfully DELETED $deleted post(s) from the database.\n";
    } catch (\Exception $e) {
        DB::rollBack();
        echo "❌ Error during deletion: " . $e->getMessage() . "\n";
        exit(1);
    }
} else {
    echo "👆 DRY RUN complete. Run with --confirm to actually delete these records.\n";
}

echo "\nDone.\n";
