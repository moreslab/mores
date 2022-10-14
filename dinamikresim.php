<?php
// <img src="dinamikresim.php?s=000_FFF_350_350&t=moreslab" >
// s – Dinamik olarak oluşturulacak olan görselin arkaplan rengi, metin rengi, genişlik ve yüksekliği belirlenmektedir.
// Belirlenen değerler alt çizgi (_) ile ayrılmaktadır. (Örneğin, 000_FFF_350_350 olarak tanımlanır.)
// t – Resmin üzerine yazmak istediğiniz metni bu parametrede belirtebilirsiniz. Hiç bir değer girmemeniz durumunda genişlik ve yükseklik değerleri yazılmaktadır.

$font       = 'verdana.ttf';
$font_size  = 10;
$setting    = isset($_GET['s']) ? $_GET['s'] : "000_FFF_350_350";
$setting    = explode("_", $setting);
$img        = array();
switch($n = count($setting)){
    case $n > 4 :
    case 3:
        $setting[3] = $setting[2];
    case 4:
        $img['width'] = (int) $setting[2];
        $img['height'] = (int) $setting[3];
    case 2:
        $img['background'] = $setting[0];
        $img['color'] = $setting[1];
    break;
    default:
        list($img['background'], $img['color'], $img['width'], $img['height']) = array('F', '0', 100, 100);
    break;
}
$background     = explode(",",hex2rgb($img['background']));
$textColorRgb   = explode(",",hex2rgb($img['color']));
$width          = empty($img['width']) ? 100 : $img['width'];
$height         = empty($img['height']) ? 100 : $img['height'];
$text           = (string) isset($_GET['t']) ? urldecode($_GET['t']) : $width ." x ". $height;
$image          = @imagecreate($width, $height) or die("Cannot Initialize new GD image stream");
$background_color   = imagecolorallocate($image, $background[0], $background[1], $background[2]);
$bounding_box_size  = imagettfbbox($font_size, 0, $font, $text);
$text_width         = $bounding_box_size[2] - $bounding_box_size[0];
$text_height        = $bounding_box_size[7]-$bounding_box_size[1];
$x = ceil(($width - $text_width) / 2);
$y = ceil(($height - $text_height) / 2);
$text_color = imagecolorallocate($image, $textColorRgb[0], $textColorRgb[1], $textColorRgb[2]);
imagettftext($image, $font_size, 0, $x, $y, $text_color, $font, $text);
header('Content-Type: image/png');
imagepng($image);
imagedestroy($image);
function hex2rgb($hex){
    $hex = str_replace("#", "", $hex);
    switch(strlen($hex)){
        case 1:
            $hex = $hex.$hex;
        case 2:
            $r = hexdec($hex);
            $g = hexdec($hex);
            $b = hexdec($hex);
        break;
        case 3:
            $r = hexdec(substr($hex,0,1).substr($hex,0,1));
            $g = hexdec(substr($hex,1,1).substr($hex,1,1));
            $b = hexdec(substr($hex,2,1).substr($hex,2,1));
        break;
        default:
            $r = hexdec(substr($hex,0,2));
            $g = hexdec(substr($hex,2,2));
            $b = hexdec(substr($hex,4,2));
        break;
    }
    $rgb = array($r, $g, $b);
    return implode(",", $rgb); 
}
?>
