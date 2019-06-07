<?php
use Slim\Http\UploadedFile;

function storage_path($dir = '')
{
	$directory = dirname(__DIR__) . "/public/storage/{$dir}";

	if (!is_dir($dir)) {
		mkdir($dir, 755, true);
	}

	return $directory;
}

function crop_image($image)
{
	$im_php = imagecreatefromjpeg($image);
	$size 	= min(imagesx($im_php), imagesy($im_php));
	$im_php = imagecrop($im_php, ['x' => $size*0.4, 'y' => 0, 'width' => $size, 'height' => $size]);
	$im_php = imagescale($im_php, 300);

	return $im_php;
}

function moveUploadedFile($directory, UploadedFile $uploadedFile)
{
    $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
    $basename  = bin2hex(random_bytes(8));
    $filename  = sprintf('%s.%0.8s', $basename, $extension);

    if (!is_dir($directory)) {
    	mkdir($directory);
    }

    if (!is_writable($directory)) {
    	chmod($directory, '775');
    }

    $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

    return $filename;
}

function auth() {

	return $this->container->auth;
}

function stri_slug($text) {

	$text = html_entity_decode(trim($text), ENT_QUOTES, 'UTF-8');
	$text=str_replace(" ","-", $text);
	$text=str_replace("–","-", $text);
	$text=str_replace("--","-", $text);
	$text=str_replace("@","-",$text);
	$text=str_replace("/","-",$text);
	$text=str_replace("\\","-",$text);
	$text=str_replace(":","",$text);
	$text=str_replace("\"","",$text);
	$text=str_replace("'","",$text);
	$text=str_replace("<","",$text);
	$text=str_replace(">","",$text);
	$text=str_replace(",","",$text);
	$text=str_replace("?","",$text);
	$text=str_replace(";","",$text);
	$text=str_replace(".","",$text);
	$text=str_replace("[","",$text);
	$text=str_replace("]","",$text);
	$text=str_replace("(","",$text);
	$text=str_replace(")","",$text);
	$text=str_replace("*","",$text);
	$text=str_replace("!","",$text);
	$text=str_replace("$","-",$text);
	$text=str_replace("&","-and-",$text);
	$text=str_replace("%","",$text);
	$text=str_replace("#","",$text);
	$text=str_replace("^","",$text);
	$text=str_replace("=","",$text);
	$text=str_replace("+","",$text);
	$text=str_replace("~","",$text);
	$text=str_replace("`","",$text);
	$text=str_replace("--","-",$text);
	$text = preg_replace("/(Г?|Г?|б ?|б ?|Г?|Г?|б ?|б ?|б ?|б ?|б ?|Д?|б ?|б ?|б ?|б ?|б ?)/", 'a', $text);
	$text = preg_replace("/(aМ?|aМ?|aМ?|aМ?|aМ?|Г?|Г?М?|Г?М?|Г?М?|Г?М?|Г?М?|Д?|Д?М?|ДМ?|Д?М?|Д?М?|Д?М?)/", 'a', $text);
	$text = preg_replace("/(ГЁ|Г?|б  |б  |б  |Г?|б ?|б  |б ?|б ?|б ?)/", 'e', $text);$text = preg_replace("/(eМ?|eМ?|eМ?|eМ?|eМ?|Г?|Г?М?|Г?М?|Г?М?|Г?М?|Г?М?)/", 'e', $text);
	$text = preg_replace("/(Г?|Г?|б ?|б ?|Д?)/", 'i', $text);$text = preg_replace("/(iМ?|iМ?|iМ?|iМ?|iМ?)/", 'i', $text);
	$text = preg_replace("/(Г?|Г?|б ?|б ?|Г?|Г?|б ?|б ?|б ?|б ?|б ?|Ж?|б ?|б ?|б ?|б ?|б ?)/", 'o', $text);$text = preg_replace("/(oМ?|oМ?|oМ?|oМ?|oМ?|Г?|Г?М?|Г?М?|Г?М?|Г?М?|Г?М?|Ж?|Ж?М?|Ж?М?|Ж?М?|Ж?М?|Ж?М?)/", 'o', $text);
	$text = preg_replace("/(Г |Г |б ?|б ?|Е?|Ж?|б ?|б ?|б ?|б ?|б ?)/", 'u', $text);$text = preg_replace("/(uМ?|uМ?|uМ?|uМ?|uМ?|Ж?|Ж?М?|Ж?М?|Ж?М?|Ж?М?|Ж?М?)/", 'u', $text);
	$text = preg_replace("/(б ?|Г |б ?|б ?|б  )/", 'y', $text);$text = preg_replace("/(Д?)/", 'd', $text);
	$text = preg_replace("/(yМ?|yМ?|yМ?|yМ?|yМ?)/", 'y', $text);$text = preg_replace("/(Д?)/", 'd', $text);
	$text = preg_replace("/(Г?|Г?|б ?|б ?|Г?|Г?|б ?|б ?|б ?|б Ё|б ?|Д?|б ?|б ?|б ?|б ?|б ?)/", 'A', $text);$text = preg_replace("/(AМ?|AМ?|AМ?|AМ?|AМ?|Г?|Г?М?|Г?М?|Г?М?|Г?М?|Г?М?|Д?|Д?М?|Д?М?|Д?М|Д?М?|Д?М?)/", 'A', $text);
	$text = preg_replace("/(Г?|Г?|б ё|б  |б  |Г?|б ?|б  |б ?|б ?|б ?)/", 'E', $text);$text = preg_replace("/(EМ?|EМ?|EМ?|EМ?|EМ?|Г?|Г?М?|Г?М?|Г?М?|Г?М?|Г?М?)/", 'E', $text);
	$text = preg_replace("/(Г?|Г?|б ?|б ?|ДЁ)/", 'I', $text);$text = preg_replace("/(IМ?|IМ?|IМ?|IМ?|IМ?)/", 'I', $text);
	$text = preg_replace("/(Г?|Г?|б ?|б ?|Г?|Г?|б ?|б ?|б ?|б ?|б ?|Ж?|б ?|б ?|б ?|б ?|б ?)/", 'O', $text);$text = preg_replace("/(OМ?|OМ?|OМ?|OМ?|OМ?|Г?|Г?М?|Г?М?|Г?М?|Г?М?|Г?М?|Ж?|Ж?М?|Ж?М?|Ж?М?|Ж?М?|Ж?М?)/", 'O', $text);
	$text = preg_replace("/(Г?|Г?|б ?|б ?|ЕЁ|Ж?|б ?|б Ё|б ?|б ?|б ?)/", 'U', $text);$text = preg_replace("/(UМ?|UМ?|UМ?|UМ?|UМ?|Ж?|Ж?М?|Ж?М?|Ж?М?|Ж?М?|Ж?М?)/", 'U', $text);
	$text = preg_replace("/(б ?|Г?|б ?|б ?|б ё)/", 'Y', $text);$text = preg_replace("/(Д?)/", 'D', $text);
	$text = preg_replace("/(YМ?|YМ?|YМ?|YМ?|YМ?)/", 'Y', $text);$text = preg_replace("/(Д)/", 'D', $text);
	$text=strtolower($text);
	return $text;

}