<?php

namespace Acts\CamdramBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Acts\CamdramBundle\Entity\Play;

class PlayController extends Controller
{

    public function displayAction($mid)
    {
        $social = $this->get('acts.social_api.provider');
        $api = $social->get('google_simple');

        $topic = $api->doFreebaseTopic($mid);
        $play = new Play($topic);

        $shows = $this->getDoctrine()->getRepository('ActsCamdramBundle:Show')->findBy(array('freebase_id' => $topic['id']));

        return $this->render('ActsCamdramBundle:Play:display.html.twig', array('play' => $play, 'shows' => $shows));
    }

}
