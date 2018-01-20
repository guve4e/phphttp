<?php
/**
 * Created by PhpStorm.
 * User: home
 * Date: 1/20/18
 * Time: 11:05 AM
 */

class SocketCall extends HttpRequest
{
    /**
     * Static constructor / factory
     */
    public static function create() : SocketCall
    {
        $instance = new self();
        return $instance;
    }

    public function send()
    {

    }
}