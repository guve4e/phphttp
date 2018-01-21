<?php

interface HttpRequestInterface
{
    public static function create();
    public function send();
}