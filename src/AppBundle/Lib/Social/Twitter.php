<?php
/**
 * Created by PhpStorm.
 * User: Viktor Daróczi
 * Date: 2015.12.01.
 * Time: 18:42
 */
namespace AppBundle\Lib\Social;

use Abraham\TwitterOAuth\TwitterOAuth;
use AppBundle\AppBundle;
use AppBundle\Entity\SocialProfile;

class Twitter implements ISocial
{
    const STRING_ID = "twitter";
    const DK_CONSUMER_KEY    = "consumer_key";
    const DK_CONSUMER_SECRET = "consumer_secret";
    const DK_TOKEN           = "token";
    const DK_TOKEN_SECRET    = "token_secret";

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em = NULL;
    /**
     * @var  \Doctrine\Common\Collections\ArrayCollection
     */
    protected $_settings = NULL;
    /**
     * @var TwitterOAuth
     */
    protected $_connection = NULL;
    protected $_statuses = NULL;
    /**
     * @var \AppBundle\Entity\SocialSetting
     */
    protected $_socialSetting = NULL;
    /**
     * @var \AppBundle\Entity\SocialProfile
     */
    protected $_user = NULL;

    public function __construct(\Doctrine\ORM\EntityManager $em)
    {
        $this->em = $em;
        $this->_initSettings();

        $this->connect();
    }

    protected function _initSettings()
    {
        $this->_setSocialSetting($this->em->getRepository("AppBundle:SocialSetting")->findOneBySocialSettingStringId(self::STRING_ID));
        $q = $this->em->createQuery("
            SELECT d FROM AppBundle\Entity\SocialSettingData d
            WHERE d.socialSettingId = :id
        ")->setParameter('id', $this->getSocialSetting()->getSocialSettingId());
        $result = $q->getResult();

        $this->_settings = new \Doctrine\Common\Collections\ArrayCollection();
        /* @var $setting \AppBundle\Entity\SocialSettingData */
        foreach ($result as $setting) {
            $this->_settings->set($setting->getSocialSettingDataKey(), $setting->getSocialSettingDataValue());
        }
    }

    /**
     * @return TwitterOAuth
     */
    public function connect() {
        if (NULL === $this->_connection) {
            $this->_connection = new TwitterOAuth(
                $this->getConsumerKey(),
                $this->getConsumerSecret(),
                $this->getAccessToken(),
                $this->getAccessTokenSecret()
            );
        }
        return $this->_connection;
    }

    public function save() {

    }

    /**
     * Updates the statuses from Twitter.
     * @return $this
     */
    public function update() {
        $this->_statuses = $this->connect()->get("statuses/user_timeline", array("user_id" => (int)$this->getUser()->getPublicSocialProfileId()));
        return $this;
    }

    /**
     * Fetches the statuses from the DB.
     * return array
     */
    public function fetch()
    {
        $q = $this->em->createQuery("
            SELECT s FROM AppBundle\Entity\SocialStatus s
            WHERE s.socialProfileId = :id
        ")->setParameter("id", $this->getUser()->getSocialProfileId());

        $result = $q->getResult();
        return $result;
    }

    public function getStatuses() {
        return $this->_statuses;
    }

    public function storeStatuses() {

    }

    public function comment() {

    }

    public function share() {

    }

    public function like() {

    }

    public function getStringId()
    {
        return self::STRING_ID;
    }

    public function getConsumerKey()
    {
        return $this->_settings->get(self::DK_CONSUMER_KEY);
    }

    public function getConsumerSecret()
    {
        return $this->_settings->get(self::DK_CONSUMER_SECRET);
    }

    public function getAccessToken()
    {
        return $this->_settings->get(self::DK_TOKEN);
    }

    public function getAccessTokenSecret()
    {
        return $this->_settings->get(self::DK_TOKEN_SECRET);
    }

    /**
     * @return \AppBundle\Entity\SocialProfile
     */
    public function getUser()
    {
        return $this->_user;
    }

    /**
     * @param int|string|\AppBundle\Entity\SocialProfile $user
     */
    public function setUser($user)
    {
        if (is_a($user, "AppBundle\Entity\SocialProfile")) {
            /* @var $user \AppBundle\Entity\SocialProfile */
            if ($user->getSocialProfileId() == NULL) {
                $idKey = "screen_name";
                $value = $user->getSocialProfileScreenName();
            } else {
                $this->_user = $user;
                return $this;
            }
        } else if (is_int($user)) {
            $idKey = "user_id";
            $value = $user;
            $user = new \AppBundle\Entity\SocialProfile();
        } else {
            $idKey = "screen_name";
            $value = $user;
            $user = new \AppBundle\Entity\SocialProfile();
        }
        // No user found in DB, fetching user data:
        $twitterUser = $this->connect()->get("users/show", array($idKey => $value));

        $user->setSocialSettingId($this->getSocialSetting()->getSocialSettingId());
        $user->setPublicSocialProfileId($twitterUser->id_str);
        $user->setSocialProfileImage($twitterUser->profile_image_url);
        $user->setSocialProfileName($twitterUser->name);
        $user->setSocialProfileScreenName($twitterUser->screen_name);
        $user->setSocialProfileBackgroundColor($twitterUser->profile_background_color);
        $user->setSocialProfileLinkColor($twitterUser->profile_link_color);
        $user->setSocialProfileTextColor($twitterUser->profile_text_color);

        // Updating database:
        $this->em->persist($user);
        $this->em->flush();

        $this->_user = $user;
        return $this;
    }

    /**
     * @return \AppBundle\Entity\SocialSetting
     */
    public function getSocialSetting()
    {
        return $this->_socialSetting;
    }

    /**
     * @param \AppBundle\Entity\SocialSetting $socialSetting
     */
    protected function _setSocialSetting($socialSetting)
    {
        $this->_socialSetting = $socialSetting;
    }

    /**
     * Twitter OAuth authentication method
     *
     * @param string $redirect
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @throws RedirectException
     * @throws SocialException
     * @throws \Abraham\TwitterOAuth\TwitterOAuthException
     */
    public function userAuth($redirect, \Symfony\Component\HttpFoundation\Request $request) {
        $session = $request->getSession();
        if (!$request->get('oauth_token')) {
            $request_token = $this->connect()->oauth('oauth/request_token', array('oauth_callback' => $redirect));

            $session->set('oauth_token', $request_token['oauth_token']);
            $session->set('oauth_token_secret', $request_token['oauth_token_secret']);

            $url = $this->connect()->url('oauth/authorize', array('oauth_token' => $request_token['oauth_token']));

            $re = new RedirectException();
            $re->setUrl($url);
            throw $re;
        } else {
            $request_token = array();
            $request_token['oauth_token'] = $session->get('oauth_token');
            $request_token['oauth_token_secret'] = $session->get('oauth_token_secret');

            if ($request->get('oauth_token') && $request_token['oauth_token'] !== $request->get('oauth_token')) {
                throw new SocialException("Twitter authentication error (token mismatch: '{$request_token['oauth_token']}' != '{$request->get('oauth_token')}').");
            }
            /* @var $connection \Abraham\TwitterOAuth\TwitterOAuth */
            $connection = $this->connect();
            $connection->setOauthToken($request_token['oauth_token'], $request_token['oauth_token_secret']);
            $access_token = $connection->oauth("oauth/access_token", array("oauth_verifier" => $request->get('oauth_verifier')));

            $session->set('access_token', $access_token);

            /* @var $user \AppBundle\Entity\SocialProfile */
            $user = $this->em->getRepository("AppBundle:SocialProfile")->findOneByPublicSocialProfileId($access_token['user_id']);
            if (!$user) {
                $connection->setOauthToken($access_token['oauth_token'], $access_token['oauth_token_secret']);
                $twitterUser = $connection->get("account/verify_credentials");
                $user = new SocialProfile();
                $user->setPublicSocialProfileId($access_token['user_id']);
                $user->setSocialSettingId($this->getSocialSetting()->getSocialSettingId());
                $user->setSocialProfileName($twitterUser->name);
                $user->setSocialProfileScreenName($twitterUser->screen_name);
                $user->setSocialProfileImage($twitterUser->profile_image_url);
                // Skip saving sensitive data in demo
                //$user->setSocialProfileOauthToken($access_token['oauth_token']);
                //$user->setSocialProfileOauthTokenSecret($access_token['oauth_token_secret']);
                $this->setUser($user);
            }
        }
    }
}