<?php

require 'vendor/autoload.php';

// 接收表单上传的文件，并存储到服务器中
//var_dump($_FILES['file']['name']);
$file = $_FILES['file']['tmp_name'];//上传的文件
$fileName = $_FILES['file']['name'];//文件的名称(用来做文件名)
$path = "words/";//文件保存位置
move_uploaded_file($file, $path . $fileName);//移动API

// 使用phpword将word转为html
$phpWord = \PhpOffice\PhpWord\IOFactory::load(__DIR__.'/'.$path.$fileName);
$xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, "HTML");
$resPath = __DIR__.'/htmls/result.html';
$xmlWriter->save($resPath);

$html = file_get_contents($resPath);
echo $html;

