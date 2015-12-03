<?php

namespace AppBundle\Controller;

use AppBundle\Lib\Social\RedirectException;
use AppBundle\Lib\Social\Reply;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class DefaultController extends Controller
{
    const P_DEFAULT_TWITTER_USER = "default_twitter_user";

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $twitter = $this->get('twitter');

        $user = $this->getDoctrine()->getManager()->getRepository("AppBundle:SocialProfile")
            ->findOneBySocialProfileScreenName($this->container->getParameter(self::P_DEFAULT_TWITTER_USER));

        $twitter->setUser($user);

        return $this->render('default/index.html.twig', array(
            'user' => $twitter->getUser(),
            'backgroundColor' => $twitter->getUser()->getSocialProfileBackgroundColor(),
            'linkColor' => $twitter->getUser()->getSocialProfileLinkColor(),
            'textColor' => $twitter->getUser()->getSocialProfileTextColor(),
            'statuses' => $twitter->fetch()
        ));
    }

    /**
     * @Route("/fetch/{name}", defaults={"name" = NULL}, name="fetch_tweets")
     */
    public function fetchAction($name)
    {
        if (!$name) {
            $name = $this->container->getParameter(self::P_DEFAULT_TWITTER_USER);
        }
        $em = $this->getDoctrine()->getManager();

        $twitter = $this->get('twitter');

        $user = $em->getRepository("AppBundle:SocialProfile")
            ->findOneBySocialProfileScreenName($name);
        if (!$user) {
            $user = $name;
        }

        $socialProfile = $twitter->setUser($user)->getUser();
        foreach ($twitter->update()->getStatuses() as $status) {
            $d = new \DateTime($status->created_at);

            $socialStatus = $em->getRepository("AppBundle:SocialStatus")->findOneByPublicSocialStatusId($status->id_str);
            if (!$socialStatus) {
                $socialStatus = new \AppBundle\Entity\SocialStatus();
            }
            $socialStatus->setSocialProfileId($socialProfile->getSocialProfileId());
            $socialStatus->setPublicSocialStatusId($status->id_str);
            $socialStatus->setSocialStatusCreatedAt($d);
            $socialStatus->setSocialStatusText($status->text);

            $em->persist($socialStatus);
        }
        $em->flush();

        return $this->render('default/index.html.twig', array(
            'user' => $twitter->getUser(),
            'backgroundColor' => $twitter->getUser()->getSocialProfileBackgroundColor(),
            'linkColor' => $twitter->getUser()->getSocialProfileLinkColor(),
            'textColor' => $twitter->getUser()->getSocialProfileTextColor(),
            'statuses' => $twitter->fetch()
        ));
    }

    /**
     * @Route("/retweet/{id}", defaults={"id" = NULL}, name="retweet")
     */
    public function retweetAction($id, Request $request)
    {
        return $this->_doBasicOperation($id, $request, "retweet", "statuses/retweet");
    }

    /**
     * @Route("/favorite/{id}", defaults={"id" = NULL}, name="favorite")
     */
    public function favoriteAction($id, Request $request)
    {
        return $this->_doBasicOperation($id, $request, "favorite", "favorites/create");
    }

    protected function _doBasicOperation($id, Request $request, $routeKey, $apiEndpoint)
    {
        $session = $request->getSession();

        if ($id) {
            $session->set('op_id', $id);
        }

        return $this->_doMultipurposeOperation($id, $request, $routeKey, $apiEndpoint, array("id" => $request->getSession()->get('op_id')));
    }

    protected function _doMultipurposeOperation($id, Request $request, $routeKey, $apiEndpoint, $apiParams)
    {
        $twitter = $this->get('twitter');
        $session = $request->getSession();

        if (!$session->get('access_token')) {
            try {
                $twitter->userAuth($this->generateUrl($routeKey, array(), UrlGeneratorInterface::ABSOLUTE_URL), $request);
            } catch (RedirectException $e) {
                return $this->redirect($e->getUrl());
            }
        }
        $access_token = $session->get('access_token');
        $twitter->connect()->setOauthToken($access_token['oauth_token'], $access_token['oauth_token_secret']);

        $session->set('op_id', NULL);
        return $this->render('default/dump.html.twig', array(
            'apiEndpoint' => $apiEndpoint,
            'response' => $twitter->connect()->post($apiEndpoint, $apiParams)
        ));
    }

    /**
     * @Route("/reply/{id}", defaults={"id" = NULL}, name="reply")
     */
    public function replyAction($id, Request $request)
    {
        $twitter = $this->get('twitter');
        $session = $request->getSession();

        if ($id) {
            $session->set('op_id', $id);
        }

        $reply = new Reply();

        $form = $this->createFormBuilder($reply)
            ->setMethod('POST')
            ->add('text', 'textarea')
            ->add('submit', 'submit', array('label' => "Post Reply"))
            ->getForm();

        $form->handleRequest($request);

        if ($request->isMethod('POST') && $form->isSubmitted() && $form->isValid()) {
            return $this->_doMultipurposeOperation($id, $request, "reply", "statuses/update", array(
                    "status" => $reply->getText(),
                    "in_reply_to_status_id" => $session->get('op_id')
                )
            );
        } else {
            /* @var $status \AppBundle\Entity\SocialStatus */
            $status = $this->getDoctrine()->getManager()->getRepository("AppBundle:SocialStatus")
                ->findOneByPublicSocialStatusId($session->get('op_id'));
            if ($status) {
                /* @var $profile \AppBundle\Entity\SocialProfile */
                $profile = $this->getDoctrine()->getManager()->find("AppBundle:SocialProfile", $status->getSocialProfileId());
                $status = $status->getSocialStatusText();
                $text = "@" . $profile->getSocialProfileScreenName() . ' ';
                $form->get('text')->setData($text);
            } else {
                $status = "ERROR: status not found.";
            }
            return $this->render('default/reply.html.twig', array(
                'form'   => $form->createView(),
                'status' => $status
            ));
        }
    }

    /**
     * @Route("/about", name="about")
     */
    public function aboutAction()
    {
        return $this->render('default/about.html.twig');
    }

}
