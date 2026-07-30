<?php

$src = 'seal_and_sig_clean.png';
$dst = 'seal_and_sig_clean1.png';

$img = @imagecreatefrompng($src);

if (!$img) {
    die('Unable to load PNG');
}

imagesavealpha($img, true);
imagealphablending($img, false);

imagepng($img, $dst, 9);

imagedestroy($img);

echo "PNG cleaned successfully";
?>