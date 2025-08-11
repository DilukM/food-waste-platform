<?php

/**
 * Simple Favicon Generator for Food Share
 * Generates a custom favicon.ico file
 */

// Check if GD extension is available
if (!extension_loaded('gd')) {
  die('GD extension is required to generate favicon');
}

// Create a 32x32 image
$size = 32;
$image = imagecreatetruecolor($size, $size);

// Colors - Food Share green theme
$green = imagecolorallocate($image, 34, 197, 94);    // Green-500
$dark_green = imagecolorallocate($image, 22, 163, 74); // Green-600
$light_green = imagecolorallocate($image, 132, 204, 22); // Lime-500
$white = imagecolorallocate($image, 255, 255, 255);

// Fill background with green
imagefill($image, 0, 0, $green);

// Create a leaf-like shape
$leaf_points = array(
  8,
  16,   // Point 1 (x, y)
  16,
  8,   // Point 2
  24,
  16,  // Point 3
  16,
  24   // Point 4
);
imagefilledpolygon($image, $leaf_points, 4, $dark_green);

// Add a smaller highlight
$highlight_points = array(
  12,
  16,
  16,
  12,
  20,
  16,
  16,
  20
);
imagefilledpolygon($image, $highlight_points, 4, $light_green);

// Add "FS" text or leaf symbol
$font_size = 3;
$text = "🌱";

// For ICO format, we'll create multiple sizes
$sizes = [16, 32, 48];
$ico_data = '';

foreach ($sizes as $ico_size) {
  $ico_image = imagecreatetruecolor($ico_size, $ico_size);

  // Scale colors
  $ico_green = imagecolorallocate($ico_image, 34, 197, 94);
  $ico_dark_green = imagecolorallocate($ico_image, 22, 163, 74);
  $ico_light_green = imagecolorallocate($ico_image, 132, 204, 22);

  // Fill background
  imagefill($ico_image, 0, 0, $ico_green);

  // Scale the leaf shape
  $scale = $ico_size / 32;
  $scaled_leaf = array(
    8 * $scale,
    16 * $scale,
    16 * $scale,
    8 * $scale,
    24 * $scale,
    16 * $scale,
    16 * $scale,
    24 * $scale
  );
  imagefilledpolygon($ico_image, $scaled_leaf, 4, $ico_dark_green);

  $scaled_highlight = array(
    12 * $scale,
    16 * $scale,
    16 * $scale,
    12 * $scale,
    20 * $scale,
    16 * $scale,
    16 * $scale,
    20 * $scale
  );
  imagefilledpolygon($ico_image, $scaled_highlight, 4, $ico_light_green);

  // Convert to PNG data
  ob_start();
  imagepng($ico_image);
  $png_data = ob_get_clean();

  // For simplicity, we'll just save the 32x32 version as favicon.ico
  if ($ico_size == 32) {
    // Save as ICO (simplified - just save as PNG with .ico extension)
    file_put_contents(__DIR__ . '/favicon.ico', $png_data);
  }

  imagedestroy($ico_image);
}

// Also save as PNG for testing
ob_start();
imagepng($image);
$png_data = ob_get_clean();
file_put_contents(__DIR__ . '/favicon.png', $png_data);

// Clean up
imagedestroy($image);

echo "Favicon generated successfully!\n";
echo "Files created:\n";
echo "- favicon.ico (for browsers)\n";
echo "- favicon.png (for testing)\n";
echo "\nView the result: <a href='/favicon.png' target='_blank'>favicon.png</a>\n";
echo "Favicon generator: <a href='/favicon-generator.html' target='_blank'>favicon-generator.html</a>\n";
?>

<!DOCTYPE html>
<html>

<head>
  <title>Favicon Generated - Food Share</title>
  <link rel="icon" href="favicon.ico" type="image/x-icon">
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 20px;
    }

    .preview {
      display: inline-block;
      margin: 20px;
      text-align: center;
    }

    .favicon-large {
      width: 64px;
      height: 64px;
      image-rendering: pixelated;
    }

    .favicon-normal {
      width: 32px;
      height: 32px;
    }

    .favicon-small {
      width: 16px;
      height: 16px;
    }
  </style>
</head>

<body>
  <h1>🌱 Food Share Favicon Generated!</h1>

  <div class="preview">
    <h3>Large (64x64)</h3>
    <img src="favicon.png" class="favicon-large" alt="Favicon Large">
  </div>

  <div class="preview">
    <h3>Normal (32x32)</h3>
    <img src="favicon.png" class="favicon-normal" alt="Favicon Normal">
  </div>

  <div class="preview">
    <h3>Small (16x16)</h3>
    <img src="favicon.png" class="favicon-small" alt="Favicon Small">
  </div>

  <h2>Files Created:</h2>
  <ul>
    <li><strong>favicon.ico</strong> - For browsers (primary favicon)</li>
    <li><strong>favicon.png</strong> - For testing and preview</li>
  </ul>

  <h2>Testing:</h2>
  <p>The favicon is now active on your site! Check your browser tab to see the new icon.</p>

  <h2>Customization:</h2>
  <p>You can customize the favicon colors and design by editing the <code>generate-favicon.php</code> file.</p>

  <a href="/" style="display: inline-block; padding: 10px 20px; background: #22c55e; color: white; text-decoration: none; border-radius: 5px;">← Back to Food Share</a>
</body>

</html>