<?php

namespace App\Services;

use HTMLPurifier;
use HTMLPurifier_Config;
use Illuminate\Support\Str;

class ContentSanitizerService
{
    private HTMLPurifier $purifier;

    public function __construct()
    {
        $config = HTMLPurifier_Config::createDefault();
        $config->set('Cache.SerializerPath', storage_path('app/purifier'));
        $config->set('Core.Encoding', 'UTF-8');
        $config->set('HTML.Doctype', 'HTML 4.01 Transitional');
        $config->set(
            'HTML.Allowed',
            'h1,h2,h3,h4,h5,h6,p,br,hr,strong,em,b,i,u,s,blockquote,code,pre,' .
            'ul,ol,li,table,thead,tbody,tfoot,tr,th,td,colgroup,col,' .
            'div[class],span[class],a[href|title|target|rel],img[src|alt|title|width|height],' .
            'iframe[src|title|width|height|frameborder]'
        );
        $config->set('Attr.AllowedFrameTargets', ['_blank']);
        $config->set('Attr.EnableID', false);
        $config->set('CSS.AllowedProperties', []);
        $config->set('HTML.SafeIframe', true);
        $config->set('URI.SafeIframeRegexp', '%^https://(www\.youtube\.com/embed/|player\.vimeo\.com/video/)%');
        $config->set('URI.AllowedSchemes', [
            'http' => true,
            'https' => true,
            'mailto' => true,
            'tel' => true,
        ]);
        $config->set('AutoFormat.RemoveEmpty', true);
        $config->set('AutoFormat.AutoParagraph', false);
        $config->set('AutoFormat.Linkify', false);

        $this->purifier = new HTMLPurifier($config);
    }

    public function sanitize(string $content): string
    {
        $sanitized = $this->purifier->purify($content);
        $sanitized = preg_replace('/<a\b(?![^>]*\brel=)([^>]*)target="_blank"([^>]*)>/i', '<a$1target="_blank" rel="noopener noreferrer"$2>', $sanitized) ?? $sanitized;

        return $this->applyResponsiveEnhancements($sanitized);
    }

    private function applyResponsiveEnhancements(string $content): string
    {
        $processed = preg_replace_callback('/<img\b[^>]*>/i', function ($matches) {
            $tag = $matches[0];
            if (!Str::contains(Str::lower($tag), 'loading=')) {
                $tag = preg_replace('/\s*\/?>$/', ' loading="lazy"$0', $tag, 1) ?? $tag;
            }
            if (!Str::contains(Str::lower($tag), 'decoding=')) {
                $tag = preg_replace('/\s*\/?>$/', ' decoding="async"$0', $tag, 1) ?? $tag;
            }
            return $tag;
        }, $content) ?? $content;

        $processed = preg_replace_callback('/<table\b[^>]*>.*?<\/table>/is', function ($matches) {
            return '<div class="post-table-scroll">' . $matches[0] . '</div>';
        }, $processed) ?? $processed;

        return preg_replace_callback('/<iframe\b[^>]*>.*?<\/iframe>/is', function ($matches) {
            return '<div class="post-embed-responsive">' . $matches[0] . '</div>';
        }, $processed) ?? $processed;
    }
}
