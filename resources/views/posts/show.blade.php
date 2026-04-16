@extends('layouts.app')

@section('title', $post->meta_title)
@section('description', $post->meta_description)
@section('keywords', $post->meta_keywords)
@section('canonical', route('posts.show', [$post->type, $post->slug]))
@section('og_title', $post->meta_title)
@section('og_description', $post->meta_description)
@section('og_url', route('posts.show', [$post->type, $post->slug]))

@section('content')

@php
    $typeRouteMap = [
        'job'        => ['route' => 'posts.jobs',       'label' => 'Jobs'],
        'admit_card' => ['route' => 'posts.admit-cards','label' => 'Admit Cards'],
        'result'     => ['route' => 'posts.results',    'label' => 'Results'],
        'answer_key' => ['route' => 'posts.answer-keys','label' => 'Answer Keys'],
        'syllabus'   => ['route' => 'posts.syllabus',   'label' => 'Syllabus'],
        'blog'       => ['route' => 'posts.blogs',      'label' => 'Blog'],
    ];
    $typeInfo   = $typeRouteMap[$post->type] ?? ['route' => 'home', 'label' => 'Posts'];
    $postUrl    = route('posts.show', [$post->type, $post->slug]);

    // Important links
    $importantLinks = $post->important_links;
    if (is_string($importantLinks)) { $importantLinks = json_decode($importantLinks, true) ?? []; }
    if (!is_array($importantLinks)) { $importantLinks = []; }

    // Education labels
    $eduMap = [
        '10th_pass'=>'10th Pass','12th_pass'=>'12th Pass','graduate'=>'Graduate',
        'post_graduate'=>'Post Graduate','diploma'=>'Diploma','iti'=>'ITI',
        'btech'=>'B.Tech/B.E','mtech'=>'M.Tech/M.E','bsc'=>'B.Sc','msc'=>'M.Sc',
        'bcom'=>'B.Com','mcom'=>'M.Com','ba'=>'B.A','ma'=>'M.A','bba'=>'BBA',
        'mba'=>'MBA','ca'=>'CA','cs'=>'CS','cma'=>'CMA','llb'=>'LLB',
        'llm'=>'LLM','mbbs'=>'MBBS','bds'=>'BDS','bpharm'=>'B.Pharm',
        'mpharm'=>'M.Pharm','nursing'=>'Nursing','bed'=>'B.Ed','med'=>'M.Ed',
        'phd'=>'PhD','any_qualification'=>'Any Qualification'
    ];
    $eduLabels  = [];
    if ($post->education && is_array($post->education)) {
        foreach ($post->education as $e) { $eduLabels[] = $eduMap[$e] ?? ucwords(str_replace('_',' ',$e)); }
    }

    // Days remaining
    $daysLeft = null;
    $lastDateStr = null;
    if ($post->last_date) {
        $daysLeft   = now()->startOfDay()->diffInDays($post->last_date->startOfDay(), false);
        $lastDateStr = $post->last_date->format('d M Y');
    }

    // Org initials for logo box
    $orgName = $post->organization ?? 'GOV';
    $orgWords = explode(' ', $orgName);
    $orgInitials = '';
    foreach(array_slice($orgWords, 0, 2) as $w) { $orgInitials .= strtoupper(substr($w,0,2)) . ' '; }
    $orgInitials = trim($orgInitials);
@endphp

<style>
*{box-sizing:border-box}
.pg{padding:14px 16px;max-width:1000px;margin:0 auto;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;overflow-x:hidden}
.breadcrumb{font-size:12px;color:#9ca3af;margin-bottom:14px;display:flex;flex-wrap:wrap;gap:4px;align-items:center;line-height:1.6}
.breadcrumb a{color:#2563eb;text-decoration:none;white-space:nowrap}
.breadcrumb a:hover{text-decoration:underline}
.breadcrumb span{opacity:.5;flex-shrink:0}
.breadcrumb .current-title{color:#374151;word-break:break-word;overflow-wrap:anywhere;display:inline}
@media(max-width:820px){.breadcrumb{padding:2px 0}}

/* Layout */
.layout{display:grid;grid-template-columns:1fr 270px;gap:16px;align-items:start}
@media(max-width:820px){.layout{grid-template-columns:1fr}}
@media(max-width:820px){.sidebar{display:none}}

/* Banner Overlap Fix */
.mobile-apply-top-banner{position:fixed;top:0;left:0;right:0;z-index:2000 !important;background:#fff;border-bottom:1.5px solid #2563eb;padding:8px 12px;display:none;align-items:center;gap:12px;box-shadow:0 2px 10px rgba(0,0,0,0.1)}
body.has-banner header{top:58px !important} /* Adjust header when banner is visible */

/* Cards */
.card{background:#fff;border:0.5px solid #e5e7eb;border-radius:12px;padding:18px 20px;margin-bottom:12px}
.sec-title{font-size:14px;font-weight:600;color:#111827;margin-bottom:12px;padding-bottom:10px;border-bottom:0.5px solid #f3f4f6}
@media(max-width:820px){.card{padding:14px 16px;border-radius:10px;margin-bottom:10px}}
@media(max-width:820px){.sec-title{font-size:13px;margin-bottom:10px}}

/* Header card */
.hdr-top{display:flex;gap:12px;align-items:flex-start;margin-bottom:14px}
.org-logo{min-width:48px;width:48px;height:48px;border-radius:9px;background:#e1f5ee;border:0.5px solid #9fe1cb;display:flex;align-items:center;justify-content:center;font-size:9px;font-weight:600;color:#085041;text-align:center;line-height:1.3;flex-shrink:0}
.hdr-title{font-size:18px;font-weight:600;color:#111827;margin-bottom:5px;line-height:1.35}
.hdr-org{font-size:13px;color:#6b7280;margin-bottom:8px}
.badges{display:flex;gap:5px;flex-wrap:wrap}
.badge{font-size:10.5px;font-weight:500;padding:3px 8px;border-radius:10px;white-space:nowrap}
.b-govt{background:#e1f5ee;color:#085041}
.b-new{background:#eaf3de;color:#27500a}
.b-warn{background:#faeeda;color:#633806}
.b-info{background:#e6f1fb;color:#0c447c}
.b-purple{background:#f3e8ff;color:#6b21a8}
@media(max-width:820px){.hdr-title{font-size:15px;line-height:1.35;margin-bottom:4px}}
@media(max-width:820px){.hdr-org{font-size:12px;margin-bottom:6px}}
@media(max-width:820px){.org-logo{min-width:40px;width:40px;height:40px;font-size:8px}}

.hdr-meta{display:grid;grid-template-columns:repeat(3,1fr);gap:10px;border-top:0.5px solid #f3f4f6;padding-top:14px;margin-top:2px}
@media(max-width:820px){.hdr-meta{grid-template-columns:1fr 1fr;gap:8px;padding-top:12px}}
.meta-item{display:flex;flex-direction:column;gap:3px}
.meta-label{font-size:10px;color:#9ca3af;text-transform:uppercase;letter-spacing:.04em}
.meta-val{font-size:13px;font-weight:600;color:#111827}
@media(max-width:820px){.meta-val{font-size:12px}}

/* Row table */
.row-table{width:100%;border-collapse:collapse;font-size:13px}
.row-table tr td{padding:8px 0;border-bottom:0.5px solid #f3f4f6;vertical-align:top}
.row-table tr:last-child td{border-bottom:none}
.row-table td:first-child{color:#6b7280;width:42%;padding-right:10px;font-size:12px}
.row-table td:last-child{color:#111827;font-weight:500;font-size:12px}
@media(max-width:400px){.row-table td:first-child{width:38%;font-size:11px}.row-table td:last-child{font-size:11px}}

/* List items */
.list-items{display:flex;flex-direction:column;gap:8px}
.list-item{display:flex;gap:10px;font-size:13px;color:#374151;align-items:flex-start;line-height:1.6}
.dot{width:6px;height:6px;border-radius:50%;background:#1d9e75;flex-shrink:0;margin-top:6px}
@media(max-width:820px){.list-item{font-size:12px}}

/* Dates grid */
.dates-grid{display:grid;grid-template-columns:1fr 1fr;gap:10px}
@media(max-width:380px){.dates-grid{grid-template-columns:1fr}}
.date-card{background:#f9fafb;border-radius:8px;padding:12px 14px;border:0.5px solid #e5e7eb}
.date-label{font-size:10px;color:#9ca3af;margin-bottom:4px;text-transform:uppercase;letter-spacing:.03em}
.date-val{font-size:13px;font-weight:600;color:#111827}
.date-card.urgent{background:#fff5f5;border-color:#fecaca}
.date-card.urgent .date-val{color:#b91c1c}
.date-card.urgent .date-label{color:#b91c1c}
@media(max-width:820px){.date-card{padding:10px 12px}}
@media(max-width:820px){.date-val{font-size:12px}}

/* Links grid */
.links-grid{display:grid;grid-template-columns:1fr 1fr;gap:8px}
@media(max-width:540px){.links-grid{grid-template-columns:1fr}}
.link-btn{display:flex;align-items:center;justify-content:space-between;gap:8px;padding:10px 14px;background:#f0fdf4;border:0.5px solid #bbf7d0;border-radius:8px;text-decoration:none;transition:.2s;cursor:pointer}
.link-btn:hover{background:#dcfce7;border-color:#4ade80}
.link-btn-label{font-size:13px;font-weight:600;color:#065f46;overflow:hidden;white-space:nowrap;text-overflow:ellipsis}
.link-arrow{color:#10b981;flex-shrink:0}

/* Content body */
.post-content-body{font-size:14px;line-height:1.75;color:#374151}
.post-content-body h1,.post-content-body h2,.post-content-body h3,.post-content-body h4{font-weight:700;color:#111827;margin-top:1.5em;margin-bottom:.65em;line-height:1.3}
.post-content-body h2{font-size:1.4rem;padding:12px 16px;background:#eff6ff;border-left:4px solid #2563eb;border-radius:4px;margin-top:1.8em}
.post-content-body h3{font-size:1.15rem;padding:10px 14px;background:#f8fafc;border-left:4px solid #3b82f6;border-radius:4px}
.post-content-body h4{font-size:1rem;padding:8px 12px;background:#f8fafc;border-left:3px solid #94a3b8;border-radius:4px}
.post-content-body p{margin-bottom:1em}
.post-content-body a{color:#2563eb;text-decoration:underline;font-weight:500}
.post-content-body ul{padding-left:1.5em;margin-bottom:1em;list-style:disc}
.post-content-body ol{padding-left:1.5em;margin-bottom:1em;list-style:decimal}
.post-content-body li{margin-bottom:.4em;line-height:1.7}
.post-content-body table{width:100% !important;max-width:100% !important;border-collapse:collapse;margin:1.2em 0;font-size:13px;display:table;table-layout:auto}
@media(max-width:768px){ .post-content-body table{display:block;overflow-x:auto;-webkit-overflow-scrolling:touch} }
.post-content-body table tr td, .post-content-body table tr th { border: 1px solid #e2e8f0; padding: 10px; min-width: 80px; word-break: break-word; overflow-wrap: break-word; }
.post-content-body th{background:#1e3a8a;color:#fff;padding:10px 12px;text-align:left;font-weight:600}
.post-content-body td{padding:9px 12px;border-bottom:1px solid #f1f5f9;vertical-align:middle}
.post-content-body tr:nth-child(even) td{background:#f9fafb}
.post-content-body strong,.post-content-body b{color:#111827;font-weight:700}
.post-content-body blockquote{border-left:4px solid #e5e7eb;padding-left:1em;margin:1.4em 0;font-style:italic;color:#6b7280}
.post-content-body img{max-width:100%;height:auto;border-radius:.5rem;margin:1.2em 0}
.post-content-body code{background:#f3f4f6;padding:.2em .4em;border-radius:.25rem;font-size:.875em;font-family:monospace}
.post-content-body pre{background:#1f2937;color:#f9fafb;padding:1em;border-radius:.5rem;overflow-x:auto;margin:1.2em 0}
.post-content-body pre code{background:transparent;padding:0;color:inherit}
.post-content-body hr{border:none;border-top:2px solid #e5e7eb;margin:1.8em 0}

/* Sidebar */
.apply-card{background:#fff;border:1px solid #1d9e75;border-radius:12px;padding:18px;margin-bottom:14px}
.apply-title{font-size:15px;font-weight:600;color:#111827;margin-bottom:4px}
.apply-sub{font-size:12px;color:#6b7280;margin-bottom:14px}
.deadline-bar{background:#faeeda;border-radius:8px;padding:10px 12px;margin-bottom:14px;display:flex;align-items:center;gap:8px}
.deadline-text{font-size:12px;color:#633806;font-weight:500}
.apply-btn-main{display:block;width:100%;padding:10px;background:#0f6e56;color:#e1f5ee;border:none;border-radius:8px;font-size:14px;font-weight:600;text-align:center;cursor:pointer;text-decoration:none;margin-bottom:8px;transition:.2s}
.apply-btn-main:hover{background:#085041;color:#e1f5ee}
.share-row{display:flex;gap:8px;margin-top:12px;padding-top:12px;border-top:0.5px solid #f3f4f6}
.share-btn{flex:1;padding:7px 4px;background:#f9fafb;border:0.5px solid #e5e7eb;border-radius:8px;font-size:11px;color:#6b7280;cursor:pointer;text-align:center;text-decoration:none;display:flex;align-items:center;justify-content:center;gap:4px;transition:.2s}
.share-btn:hover{background:#f3f4f6}

.quick-facts{background:#fff;border:0.5px solid #e5e7eb;border-radius:12px;padding:16px;margin-bottom:14px}
.qf-title{font-size:13px;font-weight:600;color:#111827;margin-bottom:10px}
.qf-row{display:flex;justify-content:space-between;align-items:center;padding:7px 0;border-bottom:0.5px solid #f3f4f6;font-size:12px}
.qf-row:last-child{border-bottom:none}
.qf-label{color:#6b7280}
.qf-val{font-weight:600;color:#111827;text-align:right;max-width:55%}

.similar-card{background:#fff;border:0.5px solid #e5e7eb;border-radius:12px;padding:14px}
.sim-title{font-size:13px;font-weight:600;margin-bottom:10px;color:#111827}
.sim-item{padding:9px 0;border-bottom:0.5px solid #f3f4f6;cursor:pointer}
.sim-item:last-child{border-bottom:none}
.sim-item-title{font-size:13px;font-weight:500;color:#2563eb;margin-bottom:3px;line-height:1.4}
.sim-item-title:hover{text-decoration:underline}
.sim-item-org{font-size:11px;color:#6b7280}
.sim-item-meta{display:flex;gap:6px;margin-top:5px;flex-wrap:wrap}
.sim-tag{font-size:10px;padding:2px 7px;border-radius:8px;background:#f9fafb;color:#6b7280;border:0.5px solid #e5e7eb}

/* Mobile sticky bottom apply bar */
.mobile-apply-bar{display:none;position:fixed;bottom:0;left:0;right:0;background:#fff;border-top:1px solid #e5e7eb;padding:10px 16px;z-index:100;gap:8px;align-items:center;justify-content:space-between}
@media(max-width:820px){.mobile-apply-bar{display:flex}}
.mobile-apply-btn{flex:1;padding:10px;background:#0f6e56;color:#e1f5ee;border:none;border-radius:8px;font-size:13px;font-weight:600;text-align:center;cursor:pointer;text-decoration:none;display:block}
.mobile-share-btn{padding:9px 14px;background:#f3f4f6;border:0.5px solid #e5e7eb;border-radius:8px;font-size:13px;cursor:pointer;text-align:center;color:#374151;display:flex;align-items:center;gap:5px}
@media(max-width:820px){.pg{padding-bottom:72px}}

/* Puc / blog content compatibility */
.puc-result a{color:#1565C0;text-decoration:none}
.puc-blog a{color:#2563eb}
</style>

{{-- Mobile-only Quick Apply Banner (90% of traffic is mobile) --}}
@if(count($importantLinks) > 0)
    @php
        $mobileApplyLink = null;
        foreach($importantLinks as $k => $v){
            $lbl = strtolower(is_array($v) ? ($v['label'] ?? $k) : $k);
            $lu  = is_array($v) ? ($v['url'] ?? $v) : $v;
            if (!$mobileApplyLink && (str_contains($lbl,'apply') || str_contains($lbl,'official') || str_contains($lbl,'register') || str_contains($lbl,'notification'))) { 
                $mobileApplyLink = $lu; 
            }
        }
        if(!$mobileApplyLink){ 
            $first = reset($importantLinks); 
            $mobileApplyLink = is_array($first) ? ($first['url'] ?? '#') : $first; 
        }
    @endphp
    <div id="top-sticky-banner" class="mobile-apply-top-banner">
        <div style="flex:1;min-width:0">
            <div style="font-size:10px;color:#6b7280;text-transform:uppercase;font-weight:700;margin-bottom:2px">{{ $typeInfo['label'] }} · {{ $post->state ? $post->state->name : 'All India' }}</div>
            <div style="font-size:13px;font-weight:600;color:#111827;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $post->title }}</div>
        </div>
        <a href="{{ $mobileApplyLink }}" target="_blank" rel="noopener" 
           style="background:#0f6e56;color:#fff;padding:9px 14px;border-radius:8px;text-decoration:none;font-size:12px;font-weight:700;flex-shrink:0">
           Quick Apply
        </a>
    </div>

    <script>
        (function() {
            const banner = document.getElementById('top-sticky-banner');
            if (!banner) return;
            window.addEventListener('scroll', function() {
                if (window.scrollY > 400) {
                    banner.style.display = 'flex';
                    document.body.classList.add('has-banner');
                } else {
                    banner.style.display = 'none';
                    document.body.classList.remove('has-banner');
                }
            });
        })();
    </script>
@endif

<div class="pg">
    {{-- Breadcrumb --}}
    <div class="breadcrumb">
        <a href="{{ route('home') }}">Home</a>
        <span>›</span>
        <a href="{{ route($typeInfo['route']) }}">{{ $typeInfo['label'] }}</a>
        @if($post->state)
        <span>›</span>
        <a href="{{ route('states.show', $post->state) }}">{{ $post->state->name }}</a>
        @endif
        <span>›</span>
        <span class="current-title">{{ Str::limit($post->title, 65) }}</span>
    </div>

    <div class="layout">
        {{-- ====== MAIN COLUMN ====== --}}
        <div class="main">

            {{-- Header Card --}}
            <div class="card">
                <div class="hdr-top">
                    <div class="org-logo">{{ $orgInitials }}</div>
                    <div style="flex:1;min-width:0">
                        <h1 class="hdr-title">{{ $post->title }}</h1>
                        @if($post->organization)
                        <div class="hdr-org">{{ $post->organization }}@if($post->state) · {{ $post->state->name }}@endif</div>
                        @endif
                        <div class="badges">
                            <span class="badge b-govt">{{ $typeInfo['label'] }}</span>
                            @if($post->isNew())<span class="badge b-new">🔥 New</span>@endif
                            @if($post->last_date && $daysLeft !== null && $daysLeft >= 0)
                                <span class="badge b-warn">Apply by {{ $post->last_date->format('d M') }}</span>
                            @endif
                            @if($post->total_posts)
                                <span class="badge b-info">{{ number_format($post->total_posts) }} Vacancies</span>
                            @endif
                            @if($post->category)<span class="badge b-purple">{{ $post->category->name }}</span>@endif
                        </div>
                    </div>
                </div>

                @if($post->total_posts || $eduLabels || ($post->last_date && $daysLeft !== null))
                <div class="hdr-meta">
                    @if($post->total_posts)
                    <div class="meta-item">
                        <span class="meta-label">Total Vacancies</span>
                        <span class="meta-val">{{ number_format($post->total_posts) }} Posts</span>
                    </div>
                    @endif
                    @if($eduLabels)
                    <div class="meta-item">
                        <span class="meta-label">Qualification</span>
                        <span class="meta-val">{{ implode(' / ', array_slice($eduLabels, 0, 2)) }}</span>
                    </div>
                    @endif
                    @if($post->last_date && $daysLeft !== null)
                    <div class="meta-item">
                        <span class="meta-label">Last Date</span>
                        <span class="meta-val" @if($daysLeft < 10 && $daysLeft >= 0) style="color:#b91c1c" @endif>{{ $lastDateStr }}</span>
                    </div>
                    @endif
                </div>
                @endif
            </div>

            {{-- Important Dates Card (if any dates) --}}
            @if($post->notification_date || $post->last_date)
            <div class="card">
                <div class="sec-title">📅 Important Dates</div>
                <div class="dates-grid">
                    @if($post->notification_date)
                    <div class="date-card">
                        <div class="date-label">Notification / Start Date</div>
                        <div class="date-val">{{ $post->notification_date->format('d M Y') }}</div>
                    </div>
                    @endif
                    @if($post->last_date)
                    <div class="date-card @if($daysLeft !== null && $daysLeft <= 10 && $daysLeft >= 0) urgent @endif">
                        <div class="date-label">Last Date to Apply</div>
                        <div class="date-val">{{ $post->last_date->format('d M Y') }}
                            @if($daysLeft !== null && $daysLeft >= 0 && $daysLeft <= 30)
                                <span style="font-size:11px;font-weight:500;color:#b91c1c"> · {{ $daysLeft }} days left</span>
                            @elseif($daysLeft !== null && $daysLeft < 0)
                                <span style="font-size:11px;font-weight:500;color:#6b7280"> · Expired</span>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            {{-- Quick info card (organization, total, state) --}}
            @if($post->organization || $post->total_posts || $post->state || $eduLabels)
            <div class="card">
                <div class="sec-title">ℹ️ Quick Information</div>
                <table class="row-table">
                    @if($post->organization)
                    <tr><td>Organisation</td><td>{{ $post->organization }}</td></tr>
                    @endif
                    @if($post->total_posts)
                    <tr><td>Total Vacancies</td><td>{{ number_format($post->total_posts) }} posts</td></tr>
                    @endif
                    @if($post->state)
                    <tr><td>State</td><td><a href="{{ route('states.show', $post->state) }}" style="color:#2563eb;text-decoration:underline">{{ $post->state->name }}</a></td></tr>
                    @else
                    <tr><td>Job Location</td><td>All India</td></tr>
                    @endif
                    @if($post->category)
                    <tr><td>Category</td><td>{{ $post->category->name }}</td></tr>
                    @endif
                    @if($eduLabels)
                    <tr><td>Education Required</td><td>{{ implode(', ', $eduLabels) }}</td></tr>
                    @endif
                    @if($post->tags && count($post->tags) > 0)
                    <tr><td>Tags</td><td>{{ implode(', ', array_map(fn($t) => ucwords(str_replace('_',' ',$t)), $post->tags)) }}</td></tr>
                    @endif
                    <tr><td>Post Type</td><td>{{ ucwords(str_replace('_',' ', $post->type)) }}</td></tr>
                    <tr><td>Updated</td><td>{{ $post->updated_at->format('d M Y') }}</td></tr>
                </table>
            </div>
            @endif

            {{-- Main Content --}}
            <div class="card">
                <div class="sec-title">📋 Full Details</div>
                <div class="post-content-body">
                    {!! $post->content !!}
                </div>
            </div>

            {{-- Important Links --}}
            @if(count($importantLinks) > 0)
            <div class="card">
                <div class="sec-title">🔗 Important Links</div>
                <div class="links-grid">
                    @foreach($importantLinks as $key => $value)
                        @php
                            $linkUrl   = is_array($value) ? ($value['url'] ?? '#') : $value;
                            $linkLabel = is_array($value) ? ($value['label'] ?? ucwords(str_replace('_',' ',$key))) : ucwords(str_replace('_',' ',$key));
                        @endphp
                        <a href="{{ $linkUrl }}" target="_blank" rel="noopener noreferrer" class="link-btn">
                            <span class="link-btn-label">{{ $linkLabel }}</span>
                            <svg class="link-arrow" width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                        </a>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- How to Apply section if it's a job --}}
            @if($post->type === 'job')
            <div class="card">
                <div class="sec-title">📝 How to Apply</div>
                <div class="list-items">
                    <div class="list-item"><div class="dot"></div><span>Visit the official website of the recruiting organisation.</span></div>
                    <div class="list-item"><div class="dot"></div><span>Find the recruitment notification and click "Apply Online".</span></div>
                    <div class="list-item"><div class="dot"></div><span>Register using your mobile number and email address.</span></div>
                    <div class="list-item"><div class="dot"></div><span>Fill in your personal, educational and category details.</span></div>
                    <div class="list-item"><div class="dot"></div><span>Upload required documents (photo, signature) in specified formats.</span></div>
                    <div class="list-item"><div class="dot"></div><span>Pay the application fee online and submit; save printout for records.</span></div>
                    @if(count($importantLinks) > 0)
                    <div class="list-item"><div class="dot"></div><span>Refer to the <strong>Important Links</strong> section above for direct apply and notification links.</span></div>
                    @endif
                </div>
            </div>
            @endif

            {{-- Share Section --}}
            @php
                $encodedUrl   = urlencode($postUrl);
                $encodedTitle = urlencode($post->title . ' - ' . $postUrl);
            @endphp
            <div class="card" style="border-color:#e0f2fe">
                <div class="sec-title">📲 Share this Post</div>
                <div class="share-row">
                    <a href="https://wa.me/?text={{ $encodedTitle }}" target="_blank" rel="noopener" class="share-btn" style="background:#dcfce7;color:#166534;border-color:#bbf7d0">
                        <i class="fab fa-whatsapp"></i> WhatsApp
                    </a>
                    <a href="https://t.me/share/url?url={{ $encodedUrl }}&text={{ urlencode($post->title) }}" target="_blank" rel="noopener" class="share-btn" style="background:#e0f2fe;color:#0c4a6e;border-color:#bae6fd">
                        <i class="fab fa-telegram"></i> Telegram
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ $encodedUrl }}" target="_blank" rel="noopener" class="share-btn" style="background:#eff6ff;color:#1e40af;border-color:#bfdbfe">
                        <i class="fab fa-facebook-f"></i> Facebook
                    </a>
                    <button onclick="navigator.clipboard.writeText('{{ $postUrl }}').then(()=>this.textContent='✅ Copied!')" class="share-btn">
                        📋 Copy link
                    </button>
                </div>
            </div>

            {{-- Related Posts --}}
            @if($related->count() > 0)
            <div class="card">
                <div class="sec-title">📌 Related Posts</div>
                @foreach($related as $rel)
                <div class="sim-item">
                    <a href="{{ route('posts.show', [$rel->type, $rel->slug]) }}" class="sim-item-title" style="display:block;text-decoration:none">{{ $rel->title }}</a>
                    <div class="sim-item-org">{{ $rel->organization ?? ucwords(str_replace('_',' ',$rel->type)) }}</div>
                    <div class="sim-item-meta">
                        <span class="sim-tag">{{ ucwords(str_replace('_',' ',$rel->type)) }}</span>
                        @if($rel->state)<span class="sim-tag">{{ $rel->state->name }}</span>@endif
                        @if($rel->last_date)<span class="sim-tag">Last: {{ $rel->last_date->format('d M Y') }}</span>@endif
                    </div>
                </div>
                @endforeach
            </div>
            @endif

        </div>

        {{-- ====== SIDEBAR ====== --}}
        <div class="sidebar">

            {{-- Apply Card --}}
            <div class="apply-card">
                <div class="apply-title">{{ $post->type === 'job' ? 'Apply for this job' : 'View ' . $typeInfo['label'] }}</div>
                @if($post->organization)
                <div class="apply-sub">{{ $post->organization }}</div>
                @endif

                @if($post->last_date && $daysLeft !== null)
                <div class="deadline-bar">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><circle cx="8" cy="8" r="6.5" stroke="#BA7517" stroke-width="1.2"/><path d="M8 5v3.5l2 1.5" stroke="#BA7517" stroke-width="1.2" stroke-linecap="round"/></svg>
                    <span class="deadline-text">
                        @if($daysLeft > 0)
                            Closes in {{ $daysLeft }} days — {{ $lastDateStr }}
                        @elseif($daysLeft === 0)
                            Closes TODAY — {{ $lastDateStr }}
                        @else
                            Closed on {{ $lastDateStr }}
                        @endif
                    </span>
                </div>
                @endif

                @if(count($importantLinks) > 0)
                    @php $applyLink = null; @endphp
                    @foreach($importantLinks as $k => $v)
                        @php
                            $lbl = strtolower(is_array($v) ? ($v['label'] ?? $k) : $k);
                            $lu  = is_array($v) ? ($v['url'] ?? $v) : $v;
                            if (!$applyLink && (str_contains($lbl,'apply') || str_contains($lbl,'official') || str_contains($lbl,'register'))) { $applyLink = $lu; }
                        @endphp
                    @endforeach
                    @if(!$applyLink)
                        @php $first = reset($importantLinks); $applyLink = is_array($first) ? ($first['url'] ?? '#') : $first; @endphp
                    @endif
                    <a href="{{ $applyLink }}" target="_blank" rel="noopener" class="apply-btn-main">
                        {{ $post->type === 'job' ? '✅ Apply on Official Site' : '📄 View Official Link' }}
                    </a>
                @else
                    <a href="#" class="apply-btn-main" style="opacity:.6;pointer-events:none">Link in details below ↓</a>
                @endif

                <div class="share-row">
                    <a href="https://wa.me/?text={{ $encodedTitle }}" target="_blank" rel="noopener" class="share-btn">
                        <i class="fab fa-whatsapp" style="color:#166534"></i> <span>WhatsApp</span>
                    </a>
                    <a href="https://t.me/share/url?url={{ $encodedUrl }}&text={{ urlencode($post->title) }}" target="_blank" rel="noopener" class="share-btn">
                        <i class="fab fa-telegram" style="color:#0c4a6e"></i> <span>Telegram</span>
                    </a>
                    <button onclick="navigator.clipboard.writeText('{{ $postUrl }}').then(()=>this.textContent='✅')" class="share-btn">📋</button>
                </div>
            </div>

            {{-- Quick Facts --}}
            <div class="quick-facts">
                <div class="qf-title">Quick Facts</div>
                @if($post->organization)
                <div class="qf-row"><span class="qf-label">Organisation</span><span class="qf-val">{{ Str::limit($post->organization, 30) }}</span></div>
                @endif
                @if($post->category)
                <div class="qf-row"><span class="qf-label">Category</span><span class="qf-val">{{ $post->category->name }}</span></div>
                @endif
                @if($post->total_posts)
                <div class="qf-row"><span class="qf-label">Vacancies</span><span class="qf-val">{{ number_format($post->total_posts) }}</span></div>
                @endif
                @if($post->state)
                <div class="qf-row"><span class="qf-label">Work State</span><span class="qf-val">{{ $post->state->name }}</span></div>
                @else
                <div class="qf-row"><span class="qf-label">Location</span><span class="qf-val">All India</span></div>
                @endif
                @if($eduLabels)
                <div class="qf-row"><span class="qf-label">Education</span><span class="qf-val">{{ implode(', ', array_slice($eduLabels, 0, 2)) }}</span></div>
                @endif
                @if($post->notification_date)
                <div class="qf-row"><span class="qf-label">Start Date</span><span class="qf-val">{{ $post->notification_date->format('d M Y') }}</span></div>
                @endif
                @if($post->last_date)
                <div class="qf-row"><span class="qf-label">Last Date</span><span class="qf-val" @if($daysLeft !== null && $daysLeft <= 10 && $daysLeft >=0) style="color:#b91c1c" @endif>{{ $lastDateStr }}</span></div>
                @endif
                <div class="qf-row"><span class="qf-label">Post Type</span><span class="qf-val">{{ ucwords(str_replace('_',' ',$post->type)) }}</span></div>
                <div class="qf-row"><span class="qf-label">Views</span><span class="qf-val">{{ number_format($post->view_count) }}</span></div>
            </div>

            {{-- Similar Jobs --}}
            @if($related->count() > 0)
            <div class="similar-card">
                <div class="sim-title">Similar {{ $typeInfo['label'] }}</div>
                @foreach($related->take(4) as $rel)
                <div class="sim-item">
                    <a href="{{ route('posts.show', [$rel->type, $rel->slug]) }}" class="sim-item-title" style="display:block;text-decoration:none">{{ Str::limit($rel->title, 65) }}</a>
                    <div class="sim-item-org">{{ $rel->organization ?? ucwords(str_replace('_',' ',$rel->type)) }}</div>
                    <div class="sim-item-meta">
                        @if($rel->total_posts)<span class="sim-tag">{{ number_format($rel->total_posts) }} posts</span>@endif
                        @if($rel->last_date)<span class="sim-tag">Last: {{ $rel->last_date->format('d M') }}</span>@endif
                        @if($rel->state)<span class="sim-tag">{{ $rel->state->name }}</span>@endif
                    </div>
                </div>
                @endforeach
            </div>
            @endif

        </div>
    </div>
</div>

{{-- Mobile Sticky Bottom Bar --}}
<div class="mobile-apply-bar">
    @if(count($importantLinks) > 0)
    <a href="{{ $applyLink ?? '#' }}" target="_blank" rel="noopener" class="mobile-apply-btn">
        {{ $post->type === 'job' ? '✅ Apply Now' : '📄 View Official' }}
    </a>
    @endif
    <a href="https://wa.me/?text={{ $encodedTitle }}" target="_blank" rel="noopener" class="mobile-share-btn">
        <i class="fab fa-whatsapp" style="color:#166534"></i> Share
    </a>
</div>

<x-ad-slot position="after_post" />

<script>
// Handle external app opening for WebView
function openExternalApp(app, data) {
    var isWebView = /WebView|wv|\.0\.0\.0|Version\/[\d.]+(?!.*Safari)/.test(navigator.userAgent);
    if (isWebView) {
        var url = '';
        if (app === 'whatsapp') url = 'whatsapp://send?text=' + data;
        else if (app === 'telegram') url = 'tg://msg?text=' + data;
        if (url) {
            window.location.href = url;
            setTimeout(function() {
                if (app === 'whatsapp') window.location.href = 'https://wa.me/?text=' + data;
                else if (app === 'telegram') window.location.href = 'https://t.me/share/url?text=' + data;
            }, 1000);
        }
    }
}
</script>
@endsection
