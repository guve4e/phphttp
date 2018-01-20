<?php
/**
 * Created by PhpStorm.
 * User: home
 * Date: 1/20/18
 * Time: 11:14 AM
 */

interface HttpRequestInterface
{
    public static function create();
    public function send();
}