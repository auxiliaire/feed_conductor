<?php
/**
 * Created by PhpStorm.
 * User: Viktor Daróczi
 * Date: 2015.12.03.
 * Time: 19:27
 */

namespace AppBundle\Lib\Social;


class RedirectException extends SocialException
{
    /**
     * @var string
     */
    private $_url = NULL;

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->_url;
    }

    /**
     * @param string
     */
    public function setUrl($url)
    {
        $this->_url = $url;
    }

}