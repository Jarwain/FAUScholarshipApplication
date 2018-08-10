<?php
namespace ScholarshipApi\Util;

use Slim\Views\PhpRenderer;
/**
 * This class basically just makes it so that output data is stored in an array
 * This minimizes the risk of accidental collision.
 * In a template, use $data['var'] instead of $var to access passed variables
 */
class BetterRenderer extends PhpRenderer{
    protected function protectedIncludeScope($template, array $data) {
        $newData = ['data' => $data];
        parent::protectedIncludeScope($template, $newData);
    }
}
