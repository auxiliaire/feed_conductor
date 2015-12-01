<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SocialProfile
 *
 * @ORM\Table(name="socialProfile", uniqueConstraints={@ORM\UniqueConstraint(name="PUBLIC_ID", columns={"publicSocialProfileId"})}, indexes={@ORM\Index(name="socialSetting", columns={"socialSettingId"})})
 * @ORM\Entity
 */
class SocialProfile
{
    /**
     * @var integer
     *
     * @ORM\Column(name="socialProfileId", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $socialProfileId;

    /**
     * @var string
     *
     * @ORM\Column(name="publicSocialProfileId", type="string", length=50, nullable=false)
     */
    private $publicSocialProfileId;

    /**
     * @var integer
     *
     * @ORM\Column(name="socialSettingId", type="integer", nullable=false)
     */
    private $socialSettingId;

    /**
     * @var string
     *
     * @ORM\Column(name="socialProfileName", type="string", length=200, nullable=false)
     */
    private $socialProfileName;

    /**
     * @var string
     *
     * @ORM\Column(name="socialProfileScreenName", type="string", length=200, nullable=false)
     */
    private $socialProfileScreenName;

    /**
     * @var string
     *
     * @ORM\Column(name="socialProfileImage", type="string", length=200, nullable=false)
     */
    private $socialProfileImage;

    /**
     * @var string
     *
     * @ORM\Column(name="socialProfileBackgroundColor", type="string", length=20, nullable=false)
     */
    private $socialProfileBackgroundColor;

    /**
     * @var string
     *
     * @ORM\Column(name="socialProfileLinkColor", type="string", length=20, nullable=false)
     */
    private $socialProfileLinkColor;

    /**
     * @var string
     *
     * @ORM\Column(name="socialProfileTextColor", type="string", length=20, nullable=false)
     */
    private $socialProfileTextColor;

    /**
     * @var string
     *
     * @ORM\Column(name="socialProfileOauthToken", type="string", length=200, nullable=true)
     */
    private $socialProfileOauthToken;

    /**
     * @var string
     *
     * @ORM\Column(name="socialProfileOauthTokenSecret", type="string", length=200, nullable=true)
     */
    private $socialProfileOauthTokenSecret;



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
     * Set publicSocialProfileId
     *
     * @param string $publicSocialProfileId
     *
     * @return SocialProfile
     */
    public function setPublicSocialProfileId($publicSocialProfileId)
    {
        $this->publicSocialProfileId = $publicSocialProfileId;

        return $this;
    }

    /**
     * Get publicSocialProfileId
     *
     * @return string
     */
    public function getPublicSocialProfileId()
    {
        return $this->publicSocialProfileId;
    }

    /**
     * Set socialSettingId
     *
     * @param integer $socialSettingId
     *
     * @return SocialProfile
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
     * Set socialProfileName
     *
     * @param string $socialProfileName
     *
     * @return SocialProfile
     */
    public function setSocialProfileName($socialProfileName)
    {
        $this->socialProfileName = $socialProfileName;

        return $this;
    }

    /**
     * Get socialProfileName
     *
     * @return string
     */
    public function getSocialProfileName()
    {
        return $this->socialProfileName;
    }

    /**
     * Set socialProfileScreenName
     *
     * @param string $socialProfileScreenName
     *
     * @return SocialProfile
     */
    public function setSocialProfileScreenName($socialProfileScreenName)
    {
        $this->socialProfileScreenName = $socialProfileScreenName;

        return $this;
    }

    /**
     * Get socialProfileScreenName
     *
     * @return string
     */
    public function getSocialProfileScreenName()
    {
        return $this->socialProfileScreenName;
    }

    /**
     * Set socialProfileImage
     *
     * @param string $socialProfileImage
     *
     * @return SocialProfile
     */
    public function setSocialProfileImage($socialProfileImage)
    {
        $this->socialProfileImage = $socialProfileImage;

        return $this;
    }

    /**
     * Get socialProfileImage
     *
     * @return string
     */
    public function getSocialProfileImage()
    {
        return $this->socialProfileImage;
    }

    /**
     * Set socialProfileBackgroundColor
     *
     * @param string $socialProfileBackgroundColor
     *
     * @return SocialProfile
     */
    public function setSocialProfileBackgroundColor($socialProfileBackgroundColor)
    {
        $this->socialProfileBackgroundColor = $socialProfileBackgroundColor;

        return $this;
    }

    /**
     * Get socialProfileBackgroundColor
     *
     * @return string
     */
    public function getSocialProfileBackgroundColor()
    {
        return $this->socialProfileBackgroundColor;
    }

    /**
     * Set socialProfileLinkColor
     *
     * @param string $socialProfileLinkColor
     *
     * @return SocialProfile
     */
    public function setSocialProfileLinkColor($socialProfileLinkColor)
    {
        $this->socialProfileLinkColor = $socialProfileLinkColor;

        return $this;
    }

    /**
     * Get socialProfileLinkColor
     *
     * @return string
     */
    public function getSocialProfileLinkColor()
    {
        return $this->socialProfileLinkColor;
    }

    /**
     * Set socialProfileTextColor
     *
     * @param string $socialProfileTextColor
     *
     * @return SocialProfile
     */
    public function setSocialProfileTextColor($socialProfileTextColor)
    {
        $this->socialProfileTextColor = $socialProfileTextColor;

        return $this;
    }

    /**
     * Get socialProfileTextColor
     *
     * @return string
     */
    public function getSocialProfileTextColor()
    {
        return $this->socialProfileTextColor;
    }

    /**
     * Set socialProfileOauthToken
     *
     * @param string $socialProfileOauthToken
     *
     * @return SocialProfile
     */
    public function setSocialProfileOauthToken($socialProfileOauthToken)
    {
        $this->socialProfileOauthToken = $socialProfileOauthToken;

        return $this;
    }

    /**
     * Get socialProfileOauthToken
     *
     * @return string
     */
    public function getSocialProfileOauthToken()
    {
        return $this->socialProfileOauthToken;
    }

    /**
     * Set socialProfileOauthTokenSecret
     *
     * @param string $socialProfileOauthTokenSecret
     *
     * @return SocialProfile
     */
    public function setSocialProfileOauthTokenSecret($socialProfileOauthTokenSecret)
    {
        $this->socialProfileOauthTokenSecret = $socialProfileOauthTokenSecret;

        return $this;
    }

    /**
     * Get socialProfileOauthTokenSecret
     *
     * @return string
     */
    public function getSocialProfileOauthTokenSecret()
    {
        return $this->socialProfileOauthTokenSecret;
    }
}
