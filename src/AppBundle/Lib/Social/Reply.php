<?php
/**
 * Created by PhpStorm.
 * User: Viktor Daróczi
 * Date: 2015.12.03.
 * Time: 21:39
 */

namespace AppBundle\Lib\Social;

use Symfony\Component\Validator\Constraints as Assert;

class Reply
{
    protected $_text = NULL;

    /**
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @Assert\Length(
     *      min = 2,
     *      max = 140,
     *      minMessage = "The reply must be at least {{ limit }} characters long",
     *      maxMessage = "The reply cannot be longer than {{ limit }} characters"
     * )
     * @return string|null
     */
    public function getText()
    {
        return $this->_text;
    }

    /**
     * @param string $text
     */
    public function setText($text)
    {
        $this->_text = $text;
        return $this;
    }


}