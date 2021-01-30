<?php
/**
 * This file is part of PHPWord - A pure PHP library for reading and writing
 * word processing documents.
 *
 * PHPWord is free software distributed under the terms of the GNU Lesser
 * General Public License version 3 as published by the Free Software Foundation.
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code. For the full list of
 * contributors, visit https://github.com/PHPOffice/PHPWord/contributors.
 *
 * @see         https://github.com/PHPOffice/PHPWord
 * @copyright   2010-2018 PHPWord contributors
 * @license     http://www.gnu.org/licenses/lgpl.txt LGPL version 3
 */

namespace PhpOffice\PhpWord\Writer\HTML\Element;

use PhpOffice\PhpWord\Element\Image as ImageElement;
use PhpOffice\PhpWord\Writer\HTML\Style\Image as ImageStyleWriter;

/**
 * Image element HTML writer
 *
 * @since 0.10.0
 */
class Image extends Text
{
    /**
     * Write image
     *
     * @return string
     */
    public function write()
    {
        if (!$this->element instanceof ImageElement) {
            return '';
        }
        $content = '';
        $imageData = $this->element->getImageStringData(true);
        if ($imageData !== null) {
            $styleWriter = new ImageStyleWriter($this->element->getStyle());
            $style = $styleWriter->write();
            $imageData = 'data:' . $this->element->getImageType() . ';base64,' . $imageData;


            // 1、获取到项目根目录
            // ---- D:/phpstudy_pro/WWW/word/vendor/phpoffice/phpword/src/PhpWord/Writer/HTML/Element/
            $path = str_replace('\\','/',realpath(dirname(__FILE__).'/'))."/";
            // --- D:/phpstudy_pro/WWW/word
            $path = explode('/vendor/phpoffice/phpword/src/PhpWord/Writer/HTML/Element/',$path)[0];
            

            // 2、调用在类中新增的方法，将图片存入 D:/phpstudy_pro/WWW/word/public/images
            $imageData = $this->element->base64_image_content($imageData, $path.'/public/word_images');

            
            // 3、替换为html里要显示的格式，替换时根据项目的默认路径灵活修改
            $imgPath = str_replace($path."/","",$imageData); // 原生php版本
            // $imgPath = str_replace($path."/public/","",$imageData); // thinkphp版本
            $content .= $this->writeOpening();


            // 4、返回
            $content .= "<img border=\"0\" style=\"{$style}\" src=\"{$imgPath}\"/>";
            $content .= $this->writeClosing();

        }
        return $content;
    }
}
