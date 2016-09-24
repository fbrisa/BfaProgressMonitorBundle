<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        
        $progressManager=$this->get('bfa.progress');        
        /*@var $progressManager \Bfa\ProgressMonitorBundle\Entity\ProgressManager */
        
        // devo visualizzare la pagina e basta
        $uid = uniqid();

        $count = 100;
        session_write_close();

        $progress=$progressManager->createProgress($uid, $count, 0, array(
            'append' => "Starting test ..." . "<BR/>"
        ));


        return $this->render('AppBundle:Default:index.html.twig', array(
            'count' => $count,
            'uid' => $uid,
            'url' => $this->generateUrl('eseguiGeneraEdInvia', array("uid" => $uid)),
        ));
    }
    
    /**
     * running
     *
     * @Route("/running/{uid}", name="eseguiGeneraEdInvia")
     */
    public function eseguiGeneraEdInviaAction(\Symfony\Component\HttpFoundation\Request $request, $uid) {
        $em = $this->getDoctrine()->getManager();

        $progressManager=$this->get('bfa.progress');        
        /*@var $progressManager \Bfa\ProgressMonitorBundle\Entity\ProgressManager */
        
        session_write_close();

        $progressManager->advanceProgress($uid, 0, array(
            'html' => "<div class='text-success'>Preparazione ... " . "</div>"//html o append
        ));

        for ($t=0;$t<100;$t++) {
            $progressManager->advanceProgress($uid, 1, array(
                'append' => "<div class='text-normal'>Run $t ... </div>"
            ));
                
            usleep(1000*100);
            
            $progressManager->advanceProgress($uid, 0, array(
                'append' => "<div class='text-success'>OK</div>"
            ));
                    
        }
            
        $progressManager->advanceProgress($uid, 0, array(
            'html' => "<div class='text-success'>FINE GENERAZIONE</div>"
        ));

        return new \Symfony\Component\HttpFoundation\JsonResponse(array(
            'fatti' => $t
        ));
    }    
}
