@extends('layouts.app')

@section('title', $post->meta_title)
@section('description', $post->meta_description)
@section('keywords', $post->meta_keywords)
@section('canonical', route('posts.show', [$post->type, $post->slug]))
@section('og_title', $post->meta_title)
@section('og_description', $post->meta_description)
@section('og_url', route('posts.show', [$post->type, $post->slug]))

@section('content')
    <style>
        /* Fallback styles for jobone-premium-ui in case inline styles are missing or truncated */
        .jobone-premium-ui { 
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; 
            color: #334155; 
            font-size: 16px; 
            line-height: 1.7; 
        }
        .jobone-premium-ui p { margin: 16px 0; word-break: break-word; }
        .jobone-premium-ui a { 
            color: #2563eb; 
            text-decoration: none; 
            font-weight: 600; 
            border-bottom: 2px solid #e2e8f0; 
            transition: all 0.2s; 
        }
        .jobone-premium-ui a:hover { color: #1d4ed8; border-color: #2563eb; }
        .jobone-premium-ui strong, 
        .jobone-premium-ui b { color: #0f172a; font-weight: 700; }

        .jobone-premium-ui ul { padding: 0; margin: 20px 0; list-style: none; }
        .jobone-premium-ui li { 
            position: relative; 
            padding: 12px 16px; 
            margin: 10px 0; 
            background: #ffffff; 
            border-radius: 8px; 
            border: 1px solid #e2e8f0; 
            box-shadow: 0 1px 2px rgba(0,0,0,0.05); 
            display: flex; 
            align-items: start; 
        }
        .jobone-premium-ui li span { margin-right: 10px; }

        .jobone-premium-ui ol { padding-left: 24px; margin: 20px 0; }
        .jobone-premium-ui ol li { 
            padding: 8px 0; 
            background: transparent; 
            border: none; 
            list-style-type: decimal; 
            box-shadow: none; 
            display: list-item; 
        }

        /* Headings */
        .jobone-premium-ui h2 { 
            margin: 36px 0 20px; 
            padding: 14px 20px; 
            background: #eff6ff; 
            border-left: 6px solid #2563eb; 
            border-radius: 4px; 
            color: #1e3a8a; 
            font-size: 24px; 
            font-weight: 800; 
        }
        .jobone-premium-ui h3 { 
            margin: 32px 0 16px; 
            padding: 12px 18px; 
            background: #f8fafc; 
            border-left: 5px solid #3b82f6; 
            border-radius: 4px; 
            color: #1e40af; 
            font-size: 21px; 
            font-weight: 700; 
            box-shadow: 0 2px 4px rgba(0,0,0,0.05); 
        }
        .jobone-premium-ui h4 { 
            margin: 24px 0 12px; 
            padding: 10px 14px; 
            background: #f8fafc; 
            border-left: 4px solid #64748b; 
            border-radius: 4px; 
            color: #1e293b; 
            font-size: 19px; 
            font-weight: 700; 
        }

        /* Tables */
        .jobone-table-wrapper { 
            width: 100%; 
            overflow-x: auto; 
            -webkit-overflow-scrolling: touch; 
            margin: 24px 0; 
            border-radius: 12px; 
            border: 1px solid #e2e8f0; 
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); 
        }
        .jobone-premium-ui table { 
            width: 100%; 
            min-width: 500px; 
            border-collapse: collapse; 
            font-size: 15px; 
            background: #ffffff; 
        }
        .jobone-premium-ui th { 
            background: #1e3a8a; 
            color: #ffffff !important; 
            font-weight: 700; 
            padding: 16px; 
            text-align: left; 
            border-bottom: 3px solid #1e40af; 
        }
        .jobone-premium-ui td { 
            padding: 14px 16px; 
            border-bottom: 1px solid #f1f5f9; 
            line-height: 1.6; 
            vertical-align: middle; 
        }
        .jobone-premium-ui tr:last-child td { border-bottom: none; }
        .jobone-premium-ui tr:nth-child(even) td { background: #f9fafb; }
        .jobone-premium-ui tr:hover td { background: #f1f5f9; }

        /* Color Boxes */
        .box-info, .box-success, .box-warning, .box-danger { 
            margin: 24px 0; 
            padding: 20px; 
            border-radius: 12px; 
            border: 1px solid; 
            display: flex; 
            align-items: start; 
        }
        .box-info { background: #eff6ff; border-color: #bfdbfe; color: #1e40af; }
        .box-info::before { content: "ℹ️"; margin-right: 12px; font-size: 20px; }
        .box-success { background: #f0fdf4; border-color: #bbf7d0; color: #166534; }
        .box-success::before { content: "✅"; margin-right: 12px; font-size: 20px; }
        .box-warning { background: #fffbeb; border-color: #fef3c7; color: #92400e; }
        .box-warning::before { content: "⚠️"; margin-right: 12px; font-size: 20px; }
        .box-danger { background: #fef2f2; border-color: #fee2e2; color: #991b1b; }
        .box-danger::before { content: "🚨"; margin-right: 12px; font-size: 20px; }

        /* Post content wrapper - basic isolation */
        .post-content-wrapper {
            isolation: isolate;
            position: relative;
        }
        
        /* PUC Result Styles - scoped */
        .puc-result *{box-sizing:border-box;margin:0;padding:0}
        .puc-result{font-family:system-ui,-apple-system,sans-serif;color:#1a1a1a;line-height:1.6}
        .puc-result a{color:#1565C0;text-decoration:none}
        .puc-result .hero{background:linear-gradient(135deg,#0D2137 0%,#1B3A5C 60%,#1565C0 100%);color:#fff;padding:28px 16px 24px;text-align:center;border-radius:12px;margin-bottom:14px}
        .puc-result .badge{display:inline-block;background:#C9A84C;color:#5D3A00;font-size:10px;font-weight:600;padding:3px 12px;border-radius:20px;margin-bottom:10px;letter-spacing:0.05em;text-transform:uppercase}
        .puc-result .hero h1{font-size:clamp(16px,4vw,26px);font-weight:700;line-height:1.3;margin-bottom:6px;color:#fff;font-family:Georgia,serif}
        .puc-result .hero h1 span{color:#C9A84C}
        .puc-result .hero-meta{font-size:11px;color:rgba(255,255,255,0.7);margin-bottom:16px}
        .puc-result .hero-meta strong{color:#fff}
        .puc-result .stat-row{display:grid;grid-template-columns:repeat(3,1fr);gap:8px;max-width:420px;margin:0 auto}
        .puc-result .stat-box{background:rgba(255,255,255,0.1);border:0.5px solid rgba(255,255,255,0.18);border-radius:8px;padding:10px 6px;text-align:center}
        .puc-result .stat-num{font-size:15px;font-weight:700;color:#C9A84C;display:block}
        .puc-result .stat-label{font-size:9px;color:rgba(255,255,255,0.65);margin-top:2px;display:block;line-height:1.3}
        .puc-result .banner{background:#E8F5EE;border:0.5px solid #A8D5BE;border-radius:8px;padding:12px 14px;margin:14px 0;display:flex;align-items:flex-start;gap:10px}
        .puc-result .banner-icon{font-size:16px;flex-shrink:0;margin-top:1px}
        .puc-result .banner p{font-size:12px;color:#145235;line-height:1.6}
        .puc-result .banner strong{display:block;font-size:13px;font-weight:700;margin-bottom:2px}
        .puc-result .section{padding:18px 0 0}
        .puc-result .section h2{font-size:16px;font-weight:700;margin-bottom:2px;color:#1a1a1a;font-family:Georgia,serif}
        .puc-result .sub{font-size:12px;color:#666;margin-bottom:12px;line-height:1.5}
        .puc-result .divider{border:none;border-top:1px solid #E5E5E5;margin:18px 0}
        .puc-result .stream-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:8px;margin-bottom:14px}
        .puc-result .stream-card{border-radius:8px;padding:12px 8px;text-align:center;border:0.5px solid transparent}
        .puc-result .sc-card{background:#E8F0FE;border-color:#BBDEFB}
        .puc-result .co-card{background:#FFF8E1;border-color:#FFE082}
        .puc-result .ar-card{background:#F3E5F5;border-color:#CE93D8}
        .puc-result .stream-icon{font-size:16px;margin-bottom:4px;display:block}
        .puc-result .stream-name{font-size:9px;font-weight:700;letter-spacing:0.04em;text-transform:uppercase;margin-bottom:3px;display:block}
        .puc-result .sc-card .stream-name{color:#1565C0}
        .puc-result .co-card .stream-name{color:#5D4037}
        .puc-result .ar-card .stream-name{color:#6A1B9A}
        .puc-result .stream-pct{font-size:18px;font-weight:700;display:block}
        .puc-result .sc-card .stream-pct{color:#1565C0}
        .puc-result .co-card .stream-pct{color:#5D4037}
        .puc-result .ar-card .stream-pct{color:#6A1B9A}
        .puc-result .stream-appeared{font-size:9px;color:#666;margin-top:2px;display:block}
        .puc-result .info-grid{display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-bottom:14px}
        .puc-result .info-box{background:#FAFAFA;border:0.5px solid #E5E5E5;border-radius:8px;padding:10px 12px}
        .puc-result .info-label{font-size:10px;color:#666;text-transform:uppercase;letter-spacing:0.04em;margin-bottom:3px;display:block}
        .puc-result .info-val{font-size:13px;font-weight:600;color:#1a1a1a;display:block}
        .puc-result .topper-section{margin-bottom:18px}
        .puc-result .stream-hdr{display:flex;align-items:center;justify-content:space-between;padding:8px 12px;border-radius:8px 8px 0 0;border:0.5px solid transparent}
        .puc-result .stream-hdr.sc{background:#E8F0FE;border-color:#BBDEFB}
        .puc-result .stream-hdr.co{background:#FFF8E1;border-color:#FFE082}
        .puc-result .stream-hdr.ar{background:#F3E5F5;border-color:#CE93D8}
        .puc-result .stream-hdr .stitle{font-size:13px;font-weight:600}
        .puc-result .stream-hdr.sc .stitle{color:#1565C0}
        .puc-result .stream-hdr.co .stitle{color:#5D4037}
        .puc-result .stream-hdr.ar .stitle{color:#6A1B9A}
        .puc-result .stream-hdr .stotal{font-size:11px;color:#666}
        .puc-result .table-wrap{overflow-x:auto;border:0.5px solid #E5E5E5;border-top:none;border-radius:0 0 8px 8px}
        .puc-result table.toppers{width:100%;border-collapse:collapse;min-width:280px}
        .puc-result table.toppers thead{background:#FAFAFA}
        .puc-result table.toppers th{padding:7px 10px;font-size:10px;font-weight:700;color:#666;text-align:left;text-transform:uppercase;letter-spacing:0.04em;border-bottom:0.5px solid #E5E5E5;white-space:nowrap}
        .puc-result table.toppers td{padding:9px 10px;font-size:12px;border-bottom:0.5px solid #E5E5E5;color:#1a1a1a}
        .puc-result table.toppers tr:last-child td{border-bottom:none}
        .puc-result .rank{display:inline-flex;align-items:center;justify-content:center;width:20px;height:20px;border-radius:50%;font-size:11px;font-weight:700;flex-shrink:0}
        .puc-result .r1{background:#C9A84C;color:#5D3A00}
        .puc-result .r2{background:#E0E0E0;color:#424242}
        .puc-result .marks{display:inline-block;background:#E8F5EE;color:#1B8A5A;font-weight:700;font-size:11px;padding:2px 8px;border-radius:20px;white-space:nowrap}
        .puc-result .marks.perfect{background:#FFF3CD;color:#856404}
        .puc-result .dist-grid{display:grid;grid-template-columns:1fr 1fr;gap:10px}
        .puc-result .dist-card{border:0.5px solid #E5E5E5;border-radius:8px;overflow:hidden}
        .puc-result .dist-head{padding:7px 10px;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.05em}
        .puc-result .dist-head.top{background:#E8F5EE;color:#1B5E20}
        .puc-result .dist-head.low{background:#FDEEEC;color:#C0392B}
        .puc-result .dist-row{display:flex;justify-content:space-between;align-items:center;padding:7px 10px;border-top:0.5px solid #E5E5E5;font-size:12px;gap:6px}
        .puc-result .dist-name{color:#1a1a1a;flex:1;font-size:12px}
        .puc-result .dist-right{text-align:right;flex-shrink:0}
        .puc-result .dist-pct{font-weight:700;font-size:12px;display:block}
        .puc-result .dist-pct.hi{color:#1B8A5A}
        .puc-result .dist-pct.lo{color:#C0392B}
        .puc-result .pbar{height:3px;border-radius:2px;margin-top:2px}
        .puc-result .pbar.hi{background:#1B8A5A}
        .puc-result .pbar.lo{background:#C0392B}
        .puc-result .steps{list-style:none;padding:0;counter-reset:s}
        .puc-result .steps li{counter-increment:s;display:flex;gap:10px;align-items:flex-start;padding:8px 0;border-bottom:0.5px solid #E5E5E5;font-size:13px;color:#1a1a1a;line-height:1.5}
        .puc-result .steps li:last-child{border-bottom:none}
        .puc-result .steps li::before{content:counter(s);min-width:20px;height:20px;border-radius:50%;background:#E8F0FE;color:#1565C0;font-size:11px;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:1px}
        .puc-result code{font-family:monospace;background:#F0F0F0;padding:1px 5px;border-radius:4px;font-size:12px}
        .puc-result .next-grid{display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-bottom:14px}
        .puc-result .next-card{border:0.5px solid #E5E5E5;border-radius:8px;padding:12px}
        .puc-result .next-title{font-weight:600;margin-bottom:4px;font-size:13px;color:#1a1a1a;display:block}
        .puc-result .next-card p{color:#666;line-height:1.5;margin:0;font-size:12px}
        .puc-result .share{background:#FAFAFA;border:0.5px solid #E5E5E5;border-radius:8px;padding:12px 14px;display:flex;align-items:center;gap:8px;flex-wrap:wrap;margin:14px 0}
        .puc-result .share-label{font-size:12px;font-weight:600;color:#1a1a1a}
        .puc-result .share-btn{display:inline-block;padding:5px 12px;border-radius:20px;font-size:11px;font-weight:600;text-decoration:none}
        .puc-result .share-btn.wa{background:#E8F5EE;color:#1B5E20}
        .puc-result .share-btn.tg{background:#E8F0FE;color:#1565C0}
        .puc-result .share-btn.fb{background:#F3E5F5;color:#6A1B9A}
        .puc-result .disclaimer{background:#FAFAFA;border:0.5px solid #E5E5E5;border-radius:8px;padding:12px 14px;font-size:11px;color:#666;line-height:1.6;margin:14px 0}
        .puc-result .footer-note{text-align:center;font-size:11px;color:#666;padding:14px 0 20px;border-top:0.5px solid #E5E5E5}
        @media(max-width:480px){
        .puc-result .dist-grid,.puc-result .next-grid{grid-template-columns:1fr}
        .puc-result .stream-pct{font-size:15px}
        .puc-result .stream-grid{gap:6px}
        .puc-result .stream-card{padding:10px 4px}
        }
        
        /* PUC Blog Styles - for custom HTML content */
        .puc-blog * { box-sizing: border-box; margin: 0; padding: 0; }
        .puc-blog { font-family: 'DM Sans', -apple-system, sans-serif; color: #1A1A1A; background: #fff; font-size: 15px; line-height: 1.7; }
        .pb-hero { background: linear-gradient(135deg, #0D2137 0%, #1B3A5C 60%, #1565C0 100%); color: #fff; padding: 48px 20px 40px; text-align: center; position: relative; overflow: hidden; border-radius: 12px; margin-bottom: 24px; }
        .pb-hero-badge { display: inline-block; background: #C9A84C; color: #1A1A1A; font-size: 11px; font-weight: 600; padding: 4px 14px; border-radius: 20px; margin-bottom: 16px; letter-spacing: 0.06em; text-transform: uppercase; }
        .pb-h1 { font-family: 'Playfair Display', Georgia, serif; font-size: clamp(22px, 5vw, 36px); line-height: 1.25; margin-bottom: 12px; color: #fff; }
        .pb-h1 span { color: #C9A84C; }
        .pb-hero-meta { font-size: 13px; color: rgba(255,255,255,0.7); margin-bottom: 24px; }
        .pb-stat-row { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; max-width: 540px; margin: 0 auto; }
        .pb-stat-box { background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.15); border-radius: 10px; padding: 12px 8px; text-align: center; }
        .pb-stat-num { font-size: 22px; font-weight: 600; color: #C9A84C; display: block; }
        .pb-stat-label { font-size: 11px; color: rgba(255,255,255,0.7); margin-top: 2px; }
        .pb-banner { background: #E8F5EE; border: 1px solid #A8D5BE; border-radius: 10px; padding: 14px 16px; margin: 24px 0; display: flex; align-items: center; gap: 12px; }
        .pb-banner-icon { font-size: 24px; flex-shrink: 0; }
        .pb-banner p { font-size: 13px; color: #145235; line-height: 1.5; }
        .pb-section { padding: 32px 0 0; }
        .pb-h2 { font-family: 'Playfair Display', Georgia, serif; font-size: 20px; font-weight: 700; margin-bottom: 4px; color: #1A1A1A; }
        .pb-sub { font-size: 13px; color: #666; margin-bottom: 20px; }
        .pb-stream-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; margin-bottom: 24px; }
        .pb-stream-card { border-radius: 10px; padding: 16px; text-align: center; border: 1px solid transparent; }
        .pb-stream-card.sc { background: #E8F0FE; border-color: #BBDEFB; }
        .pb-stream-card.co { background: #FFF8E1; border-color: #FFE082; }
        .pb-stream-card.ar { background: #F3E5F5; border-color: #CE93D8; }
        .pb-stream-icon { font-size: 22px; margin-bottom: 6px; display: block; }
        .pb-stream-name { font-size: 12px; font-weight: 600; letter-spacing: 0.04em; text-transform: uppercase; margin-bottom: 4px; display: block; }
        .pb-stream-card.sc .pb-stream-name { color: #1565C0; }
        .pb-stream-card.co .pb-stream-name { color: #795548; }
        .pb-stream-card.ar .pb-stream-name { color: #6A1B9A; }
        .pb-stream-pct { font-size: 28px; font-weight: 700; display: block; }
        .pb-stream-card.sc .pb-stream-pct { color: #1565C0; }
        .pb-stream-card.co .pb-stream-pct { color: #5D4037; }
        .pb-stream-card.ar .pb-stream-pct { color: #6A1B9A; }
        .pb-stream-appeared { font-size: 11px; color: #666; margin-top: 3px; display: block; }
        .pb-info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 20px; }
        .pb-info-box { background: #FAFAFA; border: 1px solid #E5E5E5; border-radius: 8px; padding: 12px 14px; }
        .pb-info-label { font-size: 11px; color: #666; text-transform: uppercase; letter-spacing: 0.04em; margin-bottom: 4px; display: block; }
        .pb-info-val { font-size: 14px; font-weight: 600; color: #1A1A1A; display: block; }
        .pb-divider { border: none; border-top: 1px solid #E5E5E5; margin: 32px 0; }
        .pb-topper-section { margin-bottom: 24px; }
        .pb-stream-hdr { display: flex; align-items: center; gap: 10px; padding: 10px 14px; border-radius: 8px 8px 0 0; border: 1px solid transparent; }
        .pb-stream-hdr.sc { background: #E8F0FE; border-color: #BBDEFB; }
        .pb-stream-hdr.co { background: #FFF8E1; border-color: #FFE082; }
        .pb-stream-hdr.ar { background: #F3E5F5; border-color: #CE93D8; }
        .pb-stitle { font-size: 14px; font-weight: 600; }
        .pb-stream-hdr.sc .pb-stitle { color: #1565C0; }
        .pb-stream-hdr.co .pb-stitle { color: #5D4037; }
        .pb-stream-hdr.ar .pb-stitle { color: #6A1B9A; }
        .pb-stotal { font-size: 12px; color: #666; margin-left: auto; }
        .pb-toppers { width: 100%; border-collapse: collapse; border: 1px solid #E5E5E5; border-top: none; border-radius: 0 0 8px 8px; overflow: hidden; }
        .pb-toppers thead { background: #FAFAFA; }
        .pb-toppers th { padding: 9px 12px; font-size: 11px; font-weight: 600; color: #666; text-align: left; text-transform: uppercase; letter-spacing: 0.04em; border-bottom: 1px solid #E5E5E5; }
        .pb-toppers td { padding: 10px 12px; font-size: 13px; border-bottom: 1px solid #E5E5E5; }
        .pb-toppers tr:last-child td { border-bottom: none; }
        .pb-toppers tr:hover { background: #FAFAFA; }
        
        /* Mobile Responsive Styles */
        @media (max-width: 768px) {
            .pb-stream-grid, .pb-info-grid { grid-template-columns: 1fr; }
            .pb-hero { padding: 32px 16px 28px; }
            .pb-h1 { font-size: 20px; }
            .pb-stat-row { grid-template-columns: 1fr; gap: 8px; }
            .pb-stat-box { padding: 10px; }
            .pb-stat-num { font-size: 18px; }
            .pb-banner { flex-direction: column; text-align: center; padding: 12px; }
            .pb-banner-icon { font-size: 20px; }
            .pb-section { padding: 20px 0 0; }
            .pb-h2 { font-size: 18px; }
            .pb-stream-card { padding: 12px; }
            .pb-stream-pct { font-size: 24px; }
            .pb-info-box { padding: 10px 12px; }
            .pb-stream-hdr { flex-direction: column; align-items: flex-start; gap: 4px; padding: 8px 12px; }
            .pb-stotal { margin-left: 0; font-size: 11px; }
            .pb-toppers { font-size: 12px; display: block; overflow-x: auto; }
            .pb-toppers thead, .pb-toppers tbody, .pb-toppers tr { display: block; }
            .pb-toppers th, .pb-toppers td { padding: 8px 10px; font-size: 11px; }
        }
        
        /* Ensure content doesn't overflow */
        .post-content-wrapper { 
            max-width: 100%; 
            overflow-x: hidden; 
        }
        .puc-blog { 
            max-width: 100%; 
            overflow-x: hidden; 
        }
        .puc-blog table {
            width: 100%;
            display: block;
            overflow-x: auto;
        }
        
        /* Allow content to have its own styles */
        .post-content-isolated {
            display: block;
            position: relative;
            line-height: 1.75;
            color: #374151;
        }
        
        /* Typography styles for post content */
        .post-content-isolated h1,
        .post-content-isolated h2,
        .post-content-isolated h3,
        .post-content-isolated h4,
        .post-content-isolated h5,
        .post-content-isolated h6 {
            font-weight: 700;
            color: #111827;
            margin-top: 1.5em;
            margin-bottom: 0.75em;
            line-height: 1.3;
        }
        
        .post-content-isolated h1 { font-size: 1.875rem; }
        .post-content-isolated h2 { font-size: 1.5rem; }
        .post-content-isolated h3 { font-size: 1.25rem; }
        .post-content-isolated h4 { font-size: 1.125rem; }
        .post-content-isolated h5 { font-size: 1rem; }
        .post-content-isolated h6 { font-size: 0.875rem; }
        
        .post-content-isolated p {
            margin-bottom: 1.25em;
            line-height: 1.75;
        }
        
        .post-content-isolated ul,
        .post-content-isolated ol {
            margin-bottom: 1.25em;
            padding-left: 1.75em;
        }
        
        .post-content-isolated ul {
            list-style-type: disc;
        }
        
        .post-content-isolated ol {
            list-style-type: decimal;
        }
        
        .post-content-isolated li {
            margin-bottom: 0.5em;
            line-height: 1.75;
        }
        
        .post-content-isolated li > ul,
        .post-content-isolated li > ol {
            margin-top: 0.5em;
            margin-bottom: 0.5em;
        }
        
        .post-content-isolated a {
            color: #2563eb;
            text-decoration: underline;
            font-weight: 500;
        }
        
        .post-content-isolated a:hover {
            color: #1d4ed8;
        }
        
        .post-content-isolated strong,
        .post-content-isolated b {
            font-weight: 700;
            color: #111827;
        }
        
        .post-content-isolated em,
        .post-content-isolated i {
            font-style: italic;
        }
        
        .post-content-isolated blockquote {
            border-left: 4px solid #e5e7eb;
            padding-left: 1em;
            margin: 1.5em 0;
            font-style: italic;
            color: #6b7280;
        }
        
        /* Table wrapper for horizontal scroll on mobile */
        .post-content-isolated > table {
            display: block;
            width: 100%;
            overflow-x: auto;
            margin: 1.5em 0;
            -webkit-overflow-scrolling: touch;
        }
        
        .post-content-isolated table {
            width: 100%;
            border-collapse: collapse;
            display: table;
            min-width: 100%;
        }
        
        .post-content-isolated table thead {
            background-color: #f3f4f6;
        }
        
        .post-content-isolated table tbody {
            display: table-row-group;
        }
        
        .post-content-isolated table tr {
            display: table-row;
        }
        
        .post-content-isolated table th,
        .post-content-isolated table td {
            display: table-cell;
            border: 1px solid #d1d5db;
            padding: 0.75em 1em;
            text-align: left;
            vertical-align: top;
        }
        
        .post-content-isolated table th {
            font-weight: 700;
            color: #111827;
            background-color: #f3f4f6;
        }
        
        .post-content-isolated table tbody tr:nth-child(even) {
            background-color: #f9fafb;
        }
        
        .post-content-isolated table tbody tr:hover {
            background-color: #f0f9ff;
        }
        
        .post-content-isolated img {
            max-width: 100%;
            height: auto;
            border-radius: 0.5rem;
            margin: 1.5em 0;
        }
        
        .post-content-isolated code {
            background-color: #f3f4f6;
            padding: 0.2em 0.4em;
            border-radius: 0.25rem;
            font-size: 0.875em;
            font-family: 'Courier New', monospace;
        }
        
        .post-content-isolated pre {
            background-color: #1f2937;
            color: #f9fafb;
            padding: 1em;
            border-radius: 0.5rem;
            overflow-x: auto;
            margin: 1.5em 0;
        }
        
        .post-content-isolated pre code {
            background-color: transparent;
            padding: 0;
            color: inherit;
        }
        
        .post-content-isolated hr {
            border: none;
            border-top: 2px solid #e5e7eb;
            margin: 2em 0;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .post-content-isolated h1 { font-size: 1.5rem; }
            .post-content-isolated h2 { font-size: 1.25rem; }
            .post-content-isolated h3 { font-size: 1.125rem; }
            .post-content-isolated h4 { font-size: 1rem; }
            
            .post-content-isolated table {
                font-size: 0.875rem;
            }
            
            .post-content-isolated table th,
            .post-content-isolated table td {
                padding: 0.5em 0.75em;
            }
        }
        
        /* Mobile Responsive for jobone-premium-ui */
        @media (max-width: 640px) {
            .jobone-premium-ui { font-size: 14px; }
            .jobone-premium-ui h2 { font-size: 18px; margin: 24px 0 12px; padding: 12px 14px; }
            .jobone-premium-ui h3 { font-size: 17px; margin: 20px 0 10px; padding: 10px 12px; }
            .jobone-premium-ui h4 { font-size: 16px; margin: 18px 0 8px; padding: 10px 12px; }
            .jobone-premium-ui table { font-size: 13px; min-width: 380px; }
            .jobone-premium-ui th { padding: 12px 10px; }
            .jobone-premium-ui td { padding: 10px 12px; }
        }
        
        /* Additional content enhancements */
        .post-content-isolated h2:first-child,
        .post-content-isolated h3:first-child {
            margin-top: 0;
        }
        
        /* Better link styling in tables */
        .post-content-isolated table a {
            color: #2563eb;
            text-decoration: none;
            font-weight: 600;
            border-bottom: 1px solid transparent;
            transition: border-color 0.2s;
        }
        
        .post-content-isolated table a:hover {
            border-bottom-color: #2563eb;
        }
        
        /* Ensure proper spacing between sections */
        .post-content-isolated > *:first-child {
            margin-top: 0;
        }
        
        .post-content-isolated > *:last-child {
            margin-bottom: 0;
        }
    </style>

    <!-- Breadcrumb -->
    @php
        $typeRouteMap = [
            'job' => 'posts.jobs',
            'admit_card' => 'posts.admit-cards',
            'result' => 'posts.results',
            'answer_key' => 'posts.answer-keys',
            'syllabus' => 'posts.syllabus',
            'blog' => 'posts.blogs'
        ];
        $typeRoute = $typeRouteMap[$post->type] ?? 'home';
    @endphp
    <x-breadcrumb :items="[
        ['label' => 'Home', 'url' => route('home')],
        ['label' => ucfirst(str_replace('_', ' ', $post->type)), 'url' => route($typeRoute)],
        ['label' => $post->title, 'url' => '#']
    ]" />

    <article class="bg-white rounded-xl shadow-lg p-4 md:p-8 mb-4 md:mb-8 border border-gray-200">
        <div class="mb-4">
            <div class="flex justify-between items-start mb-3 flex-wrap gap-3">
                <h1 class="font-bold text-gray-900 flex-1 leading-tight" style="font-size: 18px; line-height: 1.4;">{{ $post->title }}</h1>
                @if ($post->isNew())
                    <span class="bg-gradient-to-r from-green-500 to-green-600 text-white px-4 py-1.5 rounded-full text-sm font-bold shadow-md animate-pulse flex items-center gap-1">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        NEW
                    </span>
                @endif
            </div>

            <div class="flex flex-wrap gap-2 mb-3">
                <span class="text-xs bg-gradient-to-r from-blue-500 to-blue-600 text-white px-3 py-1.5 rounded-full font-semibold shadow-sm">
                    <i class="fas fa-tag"></i> {{ ucfirst(str_replace('_', ' ', $post->type)) }}
                </span>
                @if ($post->category)
                    <a href="{{ route('categories.show', $post->category) }}" class="text-xs bg-gradient-to-r from-gray-600 to-gray-700 text-white px-3 py-1.5 rounded-full hover:from-gray-700 hover:to-gray-800 transition font-semibold shadow-sm">
                        <i class="fas fa-folder"></i> {{ $post->category->name }}
                    </a>
                @endif
                @if ($post->state)
                    <a href="{{ route('states.show', $post->state) }}" class="text-xs bg-gradient-to-r from-green-600 to-green-700 text-white px-3 py-1.5 rounded-full hover:from-green-700 hover:to-green-800 transition font-semibold shadow-sm">
                        <i class="fas fa-map-marker-alt"></i> {{ $post->state->name }}
                    </a>
                @endif
                @if ($post->tags && count($post->tags) > 0)
                    @foreach ($post->tags as $tag)
                        <span class="text-xs bg-gradient-to-r from-purple-500 to-purple-600 text-white px-3 py-1.5 rounded-full font-semibold shadow-sm">
                            <i class="fas fa-bookmark"></i> {{ ucfirst(str_replace('_', ' ', $tag)) }}
                        </span>
                    @endforeach
                @endif
                @if ($post->education && count($post->education) > 0)
                    @foreach ($post->education as $edu)
                        @php
                            $eduLabels = [
                                '10th_pass' => '10th Pass',
                                '12th_pass' => '12th Pass',
                                'graduate' => 'Graduate',
                                'post_graduate' => 'Post Graduate',
                                'diploma' => 'Diploma',
                                'iti' => 'ITI',
                                'btech' => 'B.Tech/B.E',
                                'mtech' => 'M.Tech/M.E',
                                'bsc' => 'B.Sc',
                                'msc' => 'M.Sc',
                                'bcom' => 'B.Com',
                                'mcom' => 'M.Com',
                                'ba' => 'B.A',
                                'ma' => 'M.A',
                                'bba' => 'BBA',
                                'mba' => 'MBA',
                                'ca' => 'CA (Chartered Accountant)',
                                'cs' => 'CS (Company Secretary)',
                                'cma' => 'CMA (Cost Accountant)',
                                'llb' => 'LLB (Law)',
                                'llm' => 'LLM (Master of Law)',
                                'mbbs' => 'MBBS',
                                'bds' => 'BDS',
                                'bpharm' => 'B.Pharm',
                                'mpharm' => 'M.Pharm',
                                'nursing' => 'Nursing',
                                'bed' => 'B.Ed',
                                'med' => 'M.Ed',
                                'phd' => 'PhD',
                                'any_qualification' => 'Any Qualification'
                            ];
                        @endphp
                        <span class="text-xs bg-gradient-to-r from-green-500 to-green-600 text-white px-3 py-1.5 rounded-full font-semibold shadow-sm">
                            <i class="fas fa-graduation-cap"></i> {{ $eduLabels[$edu] ?? ucfirst(str_replace('_', ' ', $edu)) }}
                        </span>
                    @endforeach
                @endif
            </div>

            <div class="flex justify-between items-center text-xs text-gray-600 border-t border-b border-gray-200 py-3 bg-gray-50 rounded px-3">
                <span class="flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Published: {{ $post->created_at->format('M d, Y') }}
                </span>
                <span class="flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    {{ number_format($post->view_count) }} views
                </span>
            </div>
        </div>

        <!-- Important Dates -->
        @if ($post->last_date || $post->notification_date || $post->total_posts || $post->organization)
            <div class="bg-gradient-to-r from-blue-50 via-blue-100 to-blue-50 border-l-4 border-blue-600 p-5 mb-4 rounded-r-xl shadow-sm">
                <h3 class="font-bold text-blue-900 mb-3 text-base flex items-center gap-2">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    Important Information
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    @if ($post->organization)
                        <div class="bg-white rounded-lg p-3 shadow-sm border border-blue-200">
                            <div class="text-xs text-blue-600 font-semibold mb-1">Organization</div>
                            <div class="text-sm text-blue-900 font-bold">{{ $post->organization }}</div>
                        </div>
                    @endif
                    @if ($post->notification_date)
                        <div class="bg-white rounded-lg p-3 shadow-sm border border-blue-200">
                            <div class="text-xs text-blue-600 font-semibold mb-1">Notification Date</div>
                            <div class="text-sm text-blue-900 font-bold">{{ $post->notification_date->format('M d, Y') }}</div>
                        </div>
                    @endif
                    @if ($post->last_date)
                        <div class="bg-white rounded-lg p-3 shadow-sm border border-red-200">
                            <div class="text-xs text-red-600 font-semibold mb-1">Last Date to Apply</div>
                            <div class="text-sm text-red-900 font-bold">{{ $post->last_date->format('M d, Y') }}</div>
                        </div>
                    @endif
                    @if ($post->total_posts)
                        <div class="bg-white rounded-lg p-3 shadow-sm border border-blue-200">
                            <div class="text-xs text-blue-600 font-semibold mb-1 flex items-center gap-1">
                                <i class="fa-solid fa-briefcase"></i>
                                Total Vacancies
                            </div>
                            <div class="text-sm text-blue-900 font-bold">{{ number_format($post->total_posts) }}</div>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        <!-- Main Content -->
        <div class="max-w-none mb-4 post-content-wrapper bg-white rounded-lg p-5 border border-gray-200">
            <div class="post-content-isolated">
                {!! $post->content !!}
            </div>
        </div>

        <!-- Important Links -->
        @php
            $importantLinks = $post->important_links;
            // Handle case where important_links might be a JSON string instead of array
            if (is_string($importantLinks)) {
                $importantLinks = json_decode($importantLinks, true) ?? [];
            }
            // Ensure it's an array
            if (!is_array($importantLinks)) {
                $importantLinks = [];
            }
        @endphp
        @if (count($importantLinks) > 0)
            <div class="bg-gradient-to-r from-green-50 via-green-100 to-green-50 border-l-4 border-green-600 p-5 mb-4 rounded-r-xl shadow-sm">
                <h3 class="font-bold text-green-900 mb-4 text-base flex items-center gap-2">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M12.586 4.586a2 2 0 112.828 2.828l-3 3a2 2 0 01-2.828 0 1 1 0 00-1.414 1.414 4 4 0 005.656 0l3-3a4 4 0 00-5.656-5.656l-1.5 1.5a1 1 0 101.414 1.414l1.5-1.5zm-5 5a2 2 0 012.828 0 1 1 0 101.414-1.414 4 4 0 00-5.656 0l-3 3a4 4 0 105.656 5.656l1.5-1.5a1 1 0 10-1.414-1.414l-1.5 1.5a2 2 0 11-2.828-2.828l3-3z" clip-rule="evenodd"></path>
                    </svg>
                    Important Links
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    @foreach ($importantLinks as $key => $value)
                        @if (is_array($value) && isset($value['url']))
                            {{-- Old format: array with 'label' and 'url' --}}
                            <a href="{{ $value['url'] }}" target="_blank" rel="noopener noreferrer" 
                               class="flex items-center justify-between gap-3 bg-white hover:bg-green-50 border-2 border-green-200 hover:border-green-400 rounded-lg p-4 transition-all duration-200 shadow-sm hover:shadow-md group">
                                <div class="flex items-center gap-3 flex-1 min-w-0">
                                    <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center flex-shrink-0 shadow-sm group-hover:scale-110 transition-transform">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                        </svg>
                                    </div>
                                    <span class="text-sm font-bold text-green-800 group-hover:text-green-900 truncate">
                                        {{ $value['label'] ?? ucwords(str_replace('_', ' ', $key)) }}
                                    </span>
                                </div>
                                <svg class="w-5 h-5 text-green-600 group-hover:translate-x-1 transition-transform flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </a>
                        @else
                            {{-- New format: simple key-value pairs --}}
                            <a href="{{ $value }}" target="_blank" rel="noopener noreferrer" 
                               class="flex items-center justify-between gap-3 bg-white hover:bg-green-50 border-2 border-green-200 hover:border-green-400 rounded-lg p-4 transition-all duration-200 shadow-sm hover:shadow-md group">
                                <div class="flex items-center gap-3 flex-1 min-w-0">
                                    <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center flex-shrink-0 shadow-sm group-hover:scale-110 transition-transform">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                        </svg>
                                    </div>
                                    <span class="text-sm font-bold text-green-800 group-hover:text-green-900 truncate">
                                        {{ ucwords(str_replace('_', ' ', $key)) }}
                                    </span>
                                </div>
                                <svg class="w-5 h-5 text-green-600 group-hover:translate-x-1 transition-transform flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
        @endif

    </article>

    <!-- Share Section - Outside article to avoid CSS conflicts -->
    <div class="share-section-wrapper bg-white border border-gray-200 rounded-xl p-3 md:p-6 mb-4 md:mb-8 shadow-sm">
        <h3 class="share-title font-bold text-gray-900 mb-3 md:mb-4 text-sm md:text-base flex items-center gap-2">
            <i class="fas fa-share-alt"></i> Share This Post
        </h3>
        
        @php
            $shareUrl = route('posts.show', [$post->type, $post->slug]);
            $shareTitle = $post->title;
            
            // Simple message for sharing
            $simpleMessage = "{$shareTitle} - Apply: {$shareUrl}";
            $encodedSimpleMessage = urlencode($simpleMessage);
            $encodedUrl = urlencode($shareUrl);
            $encodedTitle = urlencode($shareTitle);
        @endphp
        
        <div class="share-buttons-grid grid grid-cols-2 md:grid-cols-4 gap-2 md:gap-4">
            <!-- WhatsApp -->
            <a href="https://wa.me/?text={{ $encodedSimpleMessage }}" 
               target="_blank" 
               rel="noopener noreferrer"
               class="share-btn share-btn-whatsapp"
               style="display: flex !important; align-items: center !important; justify-content: center !important; gap: 6px !important; padding: 8px 10px !important; color: white !important; text-decoration: none !important; border-radius: 8px !important; font-weight: 600 !important; background: #25D366 !important; font-size: 12px !important; border: none !important; box-shadow: none !important;">
                <i class="fab fa-whatsapp" style="font-size: 16px !important; color: white !important; margin: 0 !important; padding: 0 !important; background: none !important; border: none !important; box-shadow: none !important;"></i>
                <span class="share-btn-text hidden sm:inline" style="color: white !important; font-size: 12px !important;">WhatsApp</span>
            </a>
            
            <!-- Telegram -->
            <a href="https://t.me/share/url?url={{ $encodedUrl }}&text={{ $encodedTitle }}" 
               target="_blank"
               rel="noopener noreferrer"
               class="share-btn share-btn-telegram"
               style="display: flex !important; align-items: center !important; justify-content: center !important; gap: 6px !important; padding: 8px 10px !important; color: white !important; text-decoration: none !important; border-radius: 8px !important; font-weight: 600 !important; background: #0088cc !important; font-size: 12px !important; border: none !important; box-shadow: none !important;">
                <i class="fab fa-telegram" style="font-size: 16px !important; color: white !important; margin: 0 !important; padding: 0 !important; background: none !important; border: none !important; box-shadow: none !important;"></i>
                <span class="share-btn-text hidden sm:inline" style="color: white !important; font-size: 12px !important;">Telegram</span>
            </a>
            
            <!-- Facebook -->
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ $encodedUrl }}" 
               target="_blank"
               rel="noopener noreferrer"
               class="share-btn share-btn-facebook"
               style="display: flex !important; align-items: center !important; justify-content: center !important; gap: 6px !important; padding: 8px 10px !important; color: white !important; text-decoration: none !important; border-radius: 8px !important; font-weight: 600 !important; background: #1877F2 !important; font-size: 12px !important; border: none !important; box-shadow: none !important;">
                <i class="fab fa-facebook-f" style="font-size: 16px !important; color: white !important; margin: 0 !important; padding: 0 !important; background: none !important; border: none !important; box-shadow: none !important;"></i>
                <span class="share-btn-text hidden sm:inline" style="color: white !important; font-size: 12px !important;">Facebook</span>
            </a>
            
            <!-- Twitter/X -->
            <a href="https://twitter.com/intent/tweet?url={{ $encodedUrl }}&text={{ $encodedTitle }}" 
               target="_blank"
               rel="noopener noreferrer"
               class="share-btn share-btn-twitter"
               style="display: flex !important; align-items: center !important; justify-content: center !important; gap: 6px !important; padding: 8px 10px !important; color: white !important; text-decoration: none !important; border-radius: 8px !important; font-weight: 600 !important; background: #000000 !important; font-size: 12px !important; border: none !important; box-shadow: none !important;">
                <i class="fab fa-twitter" style="font-size: 16px !important; color: white !important; margin: 0 !important; padding: 0 !important; background: none !important; border: none !important; box-shadow: none !important;"></i>
                <span class="share-btn-text hidden sm:inline" style="color: white !important; font-size: 12px !important;">Twitter</span>
            </a>
        </div>
        
        <p class="share-hint text-xs text-gray-700 mt-3 md:mt-4 text-center">
            <i class="fas fa-info-circle"></i> Share with your friends and help them stay updated!
        </p>
    </div>

    <!-- Ad Slot - After Post -->
    <x-ad-slot position="after_post" />

    <!-- Related Posts -->
    @if ($related->count() > 0)
        <div class="mb-8">
            <h2 class="text-xl md:text-2xl font-bold text-gray-800 mb-4"><i class="fas fa-link"></i> Related Posts</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach ($related as $relatedPost)
                    <div class="bg-white rounded-lg p-4 border border-gray-200 hover:shadow-lg transition-shadow">
                        <a href="{{ route('posts.show', ['type' => $relatedPost->type, 'post' => $relatedPost->slug]) }}" class="text-sm font-medium text-blue-600 hover:text-blue-800">
                            {{ $relatedPost->title }}
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
@endsection


<script>
// Handle external app opening for WebView
function openExternalApp(app, data) {
    // Check if running in WebView
    var isWebView = /WebView|wv|\.0\.0\.0|Version\/[\d.]+(?!.*Safari)/.test(navigator.userAgent);
    
    if (isWebView) {
        // For WebView, use native app schemes
        var url = '';
        switch(app) {
            case 'whatsapp':
                url = 'whatsapp://send?text=' + data;
                break;
            case 'telegram':
                url = 'tg://msg?text=' + data;
                break;
            case 'facebook':
                url = 'fb://page/';
                break;
            case 'twitter':
                url = 'twitter://post?message=' + data;
                break;
        }
        
        if (url) {
            // Try to open native app
            window.location.href = url;
            
            // Fallback to web version after 1 second if app not installed
            setTimeout(function() {
                if (app === 'whatsapp') {
                    window.location.href = 'https://wa.me/?text=' + data;
                } else if (app === 'telegram') {
                    window.location.href = 'https://t.me/share/url?text=' + data;
                }
            }, 1000);
        }
    }
}
</script>
