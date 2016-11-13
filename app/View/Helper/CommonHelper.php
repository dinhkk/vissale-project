<?php

/**
 * Application level View Helper
 *
 * This file is application-wide helper file. You can put all
 * application-wide helper-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Helper
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
//App::uses('AppHelper', 'View');

/**
 * Application helper
 *
 * Add your application-wide methods in the class below, your helpers
 * will inherit them.
 *
 * @package       app.View.Helper
 */
class CommonHelper extends AppHelper {

    public function parseDateTime($datetime, $format = "d-m-Y H:i:s") {

        if (empty($datetime)) {
            return '';
        }
        return date($format, strtotime($datetime));
    }

    public function parseVietnameseDate($datetime, $format = "d-m-Y")
    {
        if (empty($datetime)) {
            return '';
        }
        return date($format, strtotime($datetime));
    }

    public function parseVietnameseCurrency($number)
    {
        if (empty($number || !is_numeric($number))) {
            return 0;
        }
        setlocale(LC_MONETARY,"vi_VN");
        return money_format("%n", $number);
    }

    public function filterImageContent($content)
    {
        $pattern = "/https:(.*)\.(?:jpe?g|png|gif)/";
        if (preg_match($pattern, $content, $matches)) { // This is an image if path ends in .GIF, .PNG, .JPG or .JPEG.
            $content = preg_replace($pattern, "<img width='200' src=\"$0\"></img>", $content);

            echo $content;
        }

        return h($content);
    }
}
