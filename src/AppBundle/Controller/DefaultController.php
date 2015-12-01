<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Lib\Social\Twitter;

class DefaultController extends Controller
{
    const P_DEFAULT_TWITTER_USER = "default_twitter_user";

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $twitter = new Twitter($this->getDoctrine()->getManager());

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

        $twitter = new Twitter($em);

        //$user = $em->getRepository("AppBundle:SocialProfile")
        //    ->findOneBySocialProfileScreenName($name);

        $socialProfile = $twitter->setUser($name)->getUser();
        foreach ($twitter->update()->getStatuses() as $status) {
            $d = new \DateTime($status->created_at);

            $socialStatus = new \AppBundle\Entity\SocialStatus();
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
     * @Route("/symfony", name="symfony")
     */
    public function indexSymfonyAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index-symfony.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));
    }
}
