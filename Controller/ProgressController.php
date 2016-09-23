<?php

namespace Bfa\ProgressMonitorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use \Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/bfaprogress")
 */
class ProgressController extends Controller {
    
    /**
     * @Route("/{uid}", name="bfa_progress",options={"expose"=true})
     */    
    public function progressAction($uid) {
        $progressManager=$this->get('bfa.progress');        
        /*@var $progressManager \Bfa\CommonBundle\Entity\ProgressManager */

        $res=$progressManager->progress($uid);

        return new JsonResponse($res);
    }    
    
    /**
     * @Route("/{uid}/quit", name="bfa_progress_quit",options={"expose"=true})
     */        
    public function quitAction($uid) {
        $progressManager=$this->get('bfa.progress');        
        /*@var $progressManager \Bfa\CommonBundle\Entity\ProgressManager */

        $progressManager->quitProgress($uid);
        
        return new JsonResponse(array());
    }    
    
    
    public static function createProgress($uid,$max,$pos,$data) {
        $progressManager=$this->get('bfa.progress');        
        /*@var $progressManager \Bfa\CommonBundle\Entity\ProgressManager */
        
        $progress=$progressManager->createProgress($uid, $max, $pos, $data);
        
        return $progress;
    }
    
    
    public static function advanceProgress($uid,$num,$data) {

        $progressManager=$this->get('bfa.progress');
        
        /*@var $progressManager \Bfa\CommonBundle\Entity\ProgressManager */
        $progress=$progressManager->advanceProgress($uid, $num, $data);
        return $progress;
    }
}
