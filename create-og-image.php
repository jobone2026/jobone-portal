<?php
/**
 * Simple OG Image Generator for JobOne.in
 * 
 * This script creates a basic OG image (1200x630) with JobOne.in branding
 * Run: php create-og-image.php
 */

// Configuration
$width = 1200;
$height = 630;
$outputPath = __DIR__ . '/public/images/og-image.jpg';

// Check if GD is available
if (!extension_loaded('gd')) {
    die("Error: GD extension is not installed. Please install php-gd.\n");
}

// Create image
$image = imagecreatetruecolor($width, $height);

// Create gradient background (blue gradient)
$startColor = ['r' => 30, 'g' => 58, 'b' => 138];  // #1e3a8a
$endColor = ['r' => 59, 'g' => 130, 'b' => 246];   // #3b82f6

for ($y = 0; $y < $height; $y++) {
    $ratio = $y / $height;
    
    $r = $startColor['r'] + ($endColor['r'] - $startColor['r']) * $ratio;
    $g = $startColor['g'] + ($endColor['g'] - $startColor['g']) * $ratio;
    $b = $startColor['b'] + ($endColor['b'] - $startColor['b']) * $ratio;
    
    $color = imagecolorallocate($image, (int)$r, (int)$g, (int)$b);
    imagefilledrectangle($image, 0, $y, $width, $y + 1, $color);
}

// Colors
$white = imagecolorallocate($image, 255, 255, 255);
$lightBlue = imagecolorallocate($image, 191, 219, 254);

// Try to use logo if exists
$logoPath = __DIR__ . '/public/images/jobone-logo.png';
if (file_exists($logoPath)) {
    $logo = imagecreatefrompng($logoPath);
    if ($logo) {
        $logoWidth = imagesx($logo);
        $logoHeight = imagesy($logo);
        
        // Resize logo to fit (max 400px wide)
        $maxLogoWidth = 400;
        if ($logoWidth > $maxLogoWidth) {
            $scale = $maxLogoWidth / $logoWidth;
            $newLogoWidth = (int)($logoWidth * $scale);
            $newLogoHeight = (int)($logoHeight * $scale);
            
            $resizedLogo = imagecreatetruecolor($newLogoWidth, $newLogoHeight);
            imagealphablending($resizedLogo, false);
            imagesavealpha($resizedLogo, true);
            imagecopyresampled($resizedLogo, $logo, 0, 0, 0, 0, $newLogoWidth, $newLogoHeight, $logoWidth, $logoHeight);
            
            // Center logo
            $logoX = ($width - $newLogoWidth) / 2;
            $logoY = 150;
            imagecopy($image, $resizedLogo, (int)$logoX, (int)$logoY, 0, 0, $newLogoWidth, $newLogoHeight);
            
            imagedestroy($resizedLogo);
        } else {
            // Center logo
            $logoX = ($width - $logoWidth) / 2;
            $logoY = 150;
            imagecopy($image, $logo, (int)$logoX, (int)$logoY, 0, 0, $logoWidth, $logoHeight);
        }
        
        imagedestroy($logo);
    }
}

// Add text
$fontPath = null;
$possibleFonts = [
    '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf',
    '/System/Library/Fonts/Helvetica.ttc',
    'C:\Windows\Fonts\arialbd.ttf',
];

foreach ($possibleFonts as $font) {
    if (file_exists($font)) {
        $fontPath = $font;
        break;
    }
}

// Main title
$title = 'JobOne.in';
$tagline = 'Latest Government Jobs 2026';
$subtitle = 'SSC • UPSC • Railways • Banking • State PSC';

if ($fontPath && function_exists('imagettftext')) {
    // Title
    $fontSize = 72;
    $bbox = imagettfbbox($fontSize, 0, $fontPath, $title);
    $textWidth = abs($bbox[4] - $bbox[0]);
    $x = ($width - $textWidth) / 2;
    $y = 250;
    imagettftext($image, $fontSize, 0, (int)$x, (int)$y, $white, $fontPath, $title);
    
    // Tagline
    $fontSize = 36;
    $bbox = imagettfbbox($fontSize, 0, $fontPath, $tagline);
    $textWidth = abs($bbox[4] - $bbox[0]);
    $x = ($width - $textWidth) / 2;
    $y = 350;
    imagettftext($image, $fontSize, 0, (int)$x, (int)$y, $lightBlue, $fontPath, $tagline);
    
    // Subtitle
    $fontSize = 24;
    $bbox = imagettfbbox($fontSize, 0, $fontPath, $subtitle);
    $textWidth = abs($bbox[4] - $bbox[0]);
    $x = ($width - $textWidth) / 2;
    $y = 450;
    imagettftext($image, $fontSize, 0, (int)$x, (int)$y, $white, $fontPath, $subtitle);
} else {
    // Fallback to built-in font
    $x = ($width - (strlen($title) * 20)) / 2;
    imagestring($image, 5, (int)$x, 200, $title, $white);
    
    $x = ($width - (strlen($tagline) * 12)) / 2;
    imagestring($image, 4, (int)$x, 280, $tagline, $lightBlue);
    
    $x = ($width - (strlen($subtitle) * 10)) / 2;
    imagestring($image, 3, (int)$x, 350, $subtitle, $white);
}

// Ensure directory exists
$dir = dirname($outputPath);
if (!is_dir($dir)) {
    mkdir($dir, 0755, true);
}

// Save image
if (imagejpeg($image, $outputPath, 90)) {
    echo "✅ OG image created successfully!\n";
    echo "📁 Location: {$outputPath}\n";
    echo "📏 Size: {$width}x{$height}px\n";
    echo "💾 File size: " . number_format(filesize($outputPath) / 1024, 2) . " KB\n";
} else {
    echo "❌ Failed to create OG image\n";
}

imagedestroy($image);
