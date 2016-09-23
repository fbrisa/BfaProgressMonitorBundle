<?php

namespace Bfa\ProgressMonitorBundle\Entity;

use Doctrine\ORM\EntityManager;

/**
 * Description of ProgressManager
 *
 * @author francesco
 */
class ProgressManager {

    /**
     * Holds the Doctrine entity manager for database interaction
     * @var EntityManager 
     */
    protected $em;  
    
    public function __construct(EntityManager $em) {
        // Even though we have three properties, we only need two constructor arguments...
        $this->em = $em;
    }
    
    /*
     * @var $id
     * @returns Progress
     */
    public function caricaDaId($id) {
        $entity=$this->em->getRepository("BfaCommonBundle:Progress")->find($id);
        
        return $entity;
    }
    
    /*
     * @var $uid
     * @returns Progress
     */
    public function caricaDaUid($uid) {
        $entity=$this->em->getRepository("BfaCommonBundle:Progress")->findOneByUid($uid);
        
        return $entity;
    }
    
    
    /*
     * @returns Progress
     */
    public function createProgress($uid,$max,$pos,$data) {
        if ($uid!=null) {
            $progress=$this->caricaDaUid($uid);
            /*@var $progress Progress  */
            
            if (! $progress) {
                $progress=new Progress();
                $progress->setUid($uid);
            }
            
            $progress->setMax($max);
            $progress->setPos($pos);

                
            if (isset($data["append"])) {
                $progress->setData($progress->getData().$data["append"]);
            }
            
            $this->em->persist($progress);
            $this->em->flush();
            
            return $progress;
        }  
        
        return null;
    }

    /*
     * @returns Progress
     */   
    public function advanceProgress($uid,$num,$data) {
        if ($uid!=null) {
            $progress=$this->caricaDaUid($uid);
            /*@var $progress Progress  */

            if ($progress) {
                
                if (isset($data["append"])) {                    
                    $xdata=  json_decode($progress->getData(),true);
                    if (isset($xdata["append"])) {
                        $xdata["append"].=$data["append"];
                    } else {
                        $xdata["append"]=$data["append"];
                    }
                    $progress->setData(json_encode($xdata));
                }
                
                if (isset($data["html"])) {                    
                    $xdata=  json_decode($progress->getData(),true);
                    $xdata["html"]=$data["html"];
                    $progress->setData(json_encode($xdata));
                }
                
                
                $progress->setPos($progress->getPos()+$num);
                
                $this->em->persist($progress);
                $this->em->flush();
                
            }
            
            return $progress;
        }  
    }
    
        

    /*
     * @returns Progress
     */   
    public function quitProgress($uid) {
        if ($uid!=null) {
            $progress=$this->caricaDaUid($uid);
            /*@var $progress Progress  */

            if ($progress) {
                $this->em->remove($progress);
                $this->em->flush();
                
            }
            
            return $progress;
        }  
    }
    
    
    
    public function progress($uid) {
        
        $progress=$this->caricaDaUid($uid);
        /*@var $progress Progress  */
        
        $wait=10;
        while ((! $progress) && $wait>0) {
            $progress=$this->caricaDaUid($uid);
            
            sleep(1);
            $wait--;
        }
        
        
        if ($progress) {
            $res=array(
                'max' => $progress->getMax(),
                'progress' => $progress->getPos(),
                'data' => json_decode($progress->getData(),true)
            );
        } else {
            // il file (stranamente) non è ancora stato creato
            $res=array(
                'max' => 1,
                'progress' => 0,
                'data' => null
            );
        }
        
        return $res;
    } 
        
}
