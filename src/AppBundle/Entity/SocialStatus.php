<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SocialStatus
 *
 * @ORM\Table(name="socialStatus", uniqueConstraints={@ORM\UniqueConstraint(name="PUBLIC_ID", columns={"publicSocialStatusId"})}, indexes={@ORM\Index(name="socialProfileId", columns={"socialProfileId"})})
 * @ORM\Entity
 */
class SocialStatus
{
    /**
     * @var integer
     *
     * @ORM\Column(name="socialStatusId", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $socialStatusId;

    /**
     * @var string
     *
     * @ORM\Column(name="publicSocialStatusId", type="string", length=50, nullable=false)
     */
    private $publicSocialStatusId;

    /**
     * @var integer
     *
     * @ORM\Column(name="socialProfileId", type="integer", nullable=false)
     */
    private $socialProfileId;

    /**
     * @var string
     *
     * @ORM\Column(name="socialStatusText", type="text", length=65535, nullable=false)
     */
    private $socialStatusText;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="socialStatusCreatedAt", type="datetime", nullable=false)
     */
    private $socialStatusCreatedAt;



    /**
     * Get socialStatusId
     *
     * @return integer
     */
    public function getSocialStatusId()
    {
        return $this->socialStatusId;
    }

    /**
     * Set publicSocialStatusId
     *
     * @param string $publicSocialStatusId
     *
     * @return SocialStatus
     */
    public function setPublicSocialStatusId($publicSocialStatusId)
    {
        $this->publicSocialStatusId = $publicSocialStatusId;

        return $this;
    }

    /**
     * Get publicSocialStatusId
     *
     * @return string
     */
    public function getPublicSocialStatusId()
    {
        return $this->publicSocialStatusId;
    }

    /**
     * Set socialProfileId
     *
     * @param integer $socialProfileId
     *
     * @return SocialStatus
     */
    public function setSocialProfileId($socialProfileId)
    {
        $this->socialProfileId = $socialProfileId;

        return $this;
    }

    /**
     * Get socialProfileId
     *
     * @return integer
     */
    public function getSocialProfileId()
    {
        return $this->socialProfileId;
    }

    /**
     * Set socialStatusText
     *
     * @param string $socialStatusText
     *
     * @return SocialStatus
     */
    public function setSocialStatusText($socialStatusText)
    {
        $this->socialStatusText = $socialStatusText;

        return $this;
    }

    /**
     * Get socialStatusText
     *
     * @return string
     */
    public function getSocialStatusText()
    {
        return $this->socialStatusText;
    }

    /**
     * Set socialStatusCreatedAt
     *
     * @param \DateTime $socialStatusCreatedAt
     *
     * @return SocialStatus
     */
    public function setSocialStatusCreatedAt($socialStatusCreatedAt)
    {
        $this->socialStatusCreatedAt = $socialStatusCreatedAt;

        return $this;
    }

    /**
     * Get socialStatusCreatedAt
     *
     * @return \DateTime
     */
    public function getSocialStatusCreatedAt()
    {
        return $this->socialStatusCreatedAt;
    }
}
