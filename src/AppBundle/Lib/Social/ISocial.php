<?php
/**
 * Created by PhpStorm.
 * User: Viktor Daróczi
 * Date: 2015.12.01.
 * Time: 19:27
 */
namespace AppBundle\Lib\Social;

interface ISocial
{
    public function connect();
    public function save();
    public function update();
    public function getStatuses();
    public function storeStatuses();
    public function comment();
    public function share();
    public function like();
    public function getStringId();
}