<?php
use App\Services\ContentSanitizerService;

$sanitizer = new ContentSanitizerService();

$html = <<<'HTML'
<style>
    .custom-btn { background: red; color: white; padding: 10px; border-radius: 5px; }
</style>
<div class="blog-article-premium">
    <section class="hero" style="background: linear-gradient(to right, blue, green);">
        <h1 id="main-title" class="title">Test Title</h1>
        <p class="subtitle" style="font-size: 20px;">Sub Title</p>
    </section>
    <article class="content">
        <button type="button" class="custom-btn" style="cursor: pointer;">Click Me</button>
        <table class="data-table" style="width: 100%; border: 1px solid black;">
            <thead>
                <tr class="header-row">
                    <th style="background: #eee;">Name</th>
                    <th>Age</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="name-cell" style="color: blue;">John</td>
                    <td>25</td>
                </tr>
            </tbody>
        </table>
        <div class="flex-container" style="display: flex; gap: 20px;">
            <div style="flex: 1; background: #f0f0f0;">Col 1</div>
            <div style="flex: 1; background: #e0e0e0;">Col 2</div>
        </div>
    </article>
</div>
HTML;

$output = $sanitizer->sanitize($html);

echo "--- ORIGINAL HTML ---\n";
echo $html;
echo "\n\n--- SANITIZED HTML ---\n";
echo $output;
