<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SocialSettingData
 *
 * @ORM\Table(name="socialSettingData", uniqueConstraints={@ORM\UniqueConstraint(name="Setting", columns={"socialSettingId", "socialSettingDataKey"})}, indexes={@ORM\Index(name="DataKey", columns={"socialSettingDataKey"}), @ORM\Index(name="socialSetting", columns={"socialSettingId"})})
 * @ORM\Entity
 */
class SocialSettingData
{
    /**
     * @var integer
     *
     * @ORM\Column(name="socialSettingDataId", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $socialSettingDataId;

    /**
     * @var integer
     *
     * @ORM\Column(name="socialSettingId", type="integer", nullable=false)
     */
    private $socialSettingId;

    /**
     * @var string
     *
     * @ORM\Column(name="socialSettingDataKey", type="string", length=200, nullable=false)
     */
    private $socialSettingDataKey;

    /**
     * @var string
     *
     * @ORM\Column(name="socialSettingDataValue", type="string", length=200, nullable=false)
     */
    private $socialSettingDataValue;

    /**
     * @var string
     *
     * @ORM\Column(name="socialSettingDataType", type="string", length=45, nullable=false)
     */
    private $socialSettingDataType;



    /**
     * Get socialSettingDataId
     *
     * @return integer
     */
    public function getSocialSettingDataId()
    {
        return $this->socialSettingDataId;
    }

    /**
     * Set socialSettingId
     *
     * @param integer $socialSettingId
     *
     * @return SocialSettingData
     */
    public function setSocialSettingId($socialSettingId)
    {
        $this->socialSettingId = $socialSettingId;

        return $this;
    }

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
     * Set socialSettingDataKey
     *
     * @param string $socialSettingDataKey
     *
     * @return SocialSettingData
     */
    public function setSocialSettingDataKey($socialSettingDataKey)
    {
        $this->socialSettingDataKey = $socialSettingDataKey;

        return $this;
    }

    /**
     * Get socialSettingDataKey
     *
     * @return string
     */
    public function getSocialSettingDataKey()
    {
        return $this->socialSettingDataKey;
    }

    /**
     * Set socialSettingDataValue
     *
     * @param string $socialSettingDataValue
     *
     * @return SocialSettingData
     */
    public function setSocialSettingDataValue($socialSettingDataValue)
    {
        $this->socialSettingDataValue = $socialSettingDataValue;

        return $this;
    }

    /**
     * Get socialSettingDataValue
     *
     * @return string
     */
    public function getSocialSettingDataValue()
    {
        return $this->socialSettingDataValue;
    }

    /**
     * Set socialSettingDataType
     *
     * @param string $socialSettingDataType
     *
     * @return SocialSettingData
     */
    public function setSocialSettingDataType($socialSettingDataType)
    {
        $this->socialSettingDataType = $socialSettingDataType;

        return $this;
    }

    /**
     * Get socialSettingDataType
     *
     * @return string
     */
    public function getSocialSettingDataType()
    {
        return $this->socialSettingDataType;
    }
}
