<?php
class Captcha{
    public static function create($count=5){
        $code='';
        $charset='ABCDEFGHJKLMNOPQRSTUVWXYZ123456789';
        $len=strlen($charset) - 1;
        for($i = 0; $i < $count; $i++){
            $code .= $charset[rand(0,$len)];
        }
        return $code;
    }
    public static function show($code){
        $im = imagecreate($x=250,$y=62);
        imagecolorallocate($im,rand(50,200),rand(0,155),rand(0,155));
        $fontColor = imagecolorallocate($im,255,255,255);
        $fontStyle = COMMON_PATH.'tahoma.ttf';
        for($i = 0, $len = strlen($code); $i < $len; ++$i){
            imagettftext($im,30,rand(0,20)-rand(0,25),32+$i*40,rand(30,50),$fontColor,$fontStyle,$code[$i]);
        }
        for($i = 0; $i < 8; ++$i){
            $lineColor = imagecolorallocate($im,rand(0,255),rand(0,255),rand(0,255));
            imageline($im,rand(0,$x),0,rand(0,$x),$y,$lineColor);
        }
        for($i = 0; $i < 250; ++$i){
            imagesetpixel($im,rand(0,$x),rand(0,$y),$fontColor);
        }
        header('Content-type:image/png');
        imagepng($im);
        imagedestroy($im);
    }
}

