<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SocialSetting
 *
 * @ORM\Table(name="socialSetting", uniqueConstraints={@ORM\UniqueConstraint(name="StringId", columns={"socialSettingStringId"})})
 * @ORM\Entity
 */
class SocialSetting
{
    /**
     * @var integer
     *
     * @ORM\Column(name="socialSettingId", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $socialSettingId;

    /**
     * @var string
     *
     * @ORM\Column(name="socialSettingStringId", type="string", length=45, nullable=false)
     */
    private $socialSettingStringId;

    /**
     * @var string
     *
     * @ORM\Column(name="socialSettingName", type="string", length=45, nullable=false)
     */
    private $socialSettingName;

    /**
     * @var boolean
     *
     * @ORM\Column(name="socialSettingActive", type="boolean", nullable=false)
     */
    private $socialSettingActive;



    /**
     * Get socialSettingId
     *
     * @return integer
     */
    public function getSocialSettingId()
    {
        return $this->socialSettingId;
    }

    /**
     * Set socialSettingStringId
     *
     * @param string $socialSettingStringId
     *
     * @return SocialSetting
     */
    public function setSocialSettingStringId($socialSettingStringId)
    {
        $this->socialSettingStringId = $socialSettingStringId;

        return $this;
    }

    /**
     * Get socialSettingStringId
     *
     * @return string
     */
    public function getSocialSettingStringId()
    {
        return $this->socialSettingStringId;
    }

    /**
     * Set socialSettingName
     *
     * @param string $socialSettingName
     *
     * @return SocialSetting
     */
    public function setSocialSettingName($socialSettingName)
    {
        $this->socialSettingName = $socialSettingName;

        return $this;
    }

    /**
     * Get socialSettingName
     *
     * @return string
     */
    public function getSocialSettingName()
    {
        return $this->socialSettingName;
    }

    /**
     * Set socialSettingActive
     *
     * @param boolean $socialSettingActive
     *
     * @return SocialSetting
     */
    public function setSocialSettingActive($socialSettingActive)
    {
        $this->socialSettingActive = $socialSettingActive;

        return $this;
    }

    /**
     * Get socialSettingActive
     *
     * @return boolean
     */
    public function getSocialSettingActive()
    {
        return $this->socialSettingActive;
    }
}
