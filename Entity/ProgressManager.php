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
    
    /**
     * 
     * @param integer $id
     * @return Progress
     */
    public function caricaDaId($id) {
        $entity=$this->em->getRepository("BfaProgressMonitorBundle:Progress")->find($id);
        
        return $entity;
    }
    
    /**
     * 
     * @param string $uid
     * @return Progress
     */
    public function caricaDaUid($uid) {
        $cacheDriver = new \Doctrine\Common\Cache\ArrayCache();
        
        $entity=$this->em->getRepository("BfaProgressMonitorBundle:Progress")->findOneByUid($uid);
        
        return $entity;
    }
    
    
    /**
     * 
     * @param string $uid
     * @param integer $max
     * @param integer $pos
     * @param string $data
     * @return Progress
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

     /**
      * 
      * @param type $uid
      * @param type $num
      * @param type $data
      * @return Progress
      */
    public function advanceProgress($uid,$num,$data) {
        if ($uid!=null) {
            $progress=$this->caricaDaUid($uid);
            /*@var $progress Progress  */

            if ($progress) {
                
                $requestStop=false;
                
                //$oldData=$progress->getData(); 
                // must reload
                $oldData=$this->em->getConnection()->fetchAssoc(
                    "select data,request_stop from bfa_progress where id=:id", array('id' => $progress->getId() )
                );
                
                
                
                if (count($oldData)>0) {
                    
                    //error_log(print_r($oldData,TRUE));
                    $xdata=  json_decode($oldData['data'],true);
                    //error_log(print_r($xdata,TRUE));
                    $requestStop=$oldData['request_stop'];
                } else {
                    $xdata=array();
                }
                
                
                if (isset($data["append"])) {
                    if (isset($xdata["append"])) {
                        $xdata["append"].=$data["append"];
                    } else {
                        $xdata["append"]=$data["append"];
                    }                    
                }
                
                if (isset($data["html"])) {                    
                    $xdata["html"]=$data["html"];
                    $progress->setData(json_encode($xdata));
                }
                
                if (isset($data["data"])) {
                    if (isset($xdata["data"])) {
                        $xdata["data"][]=$data["data"];
                    } else {
                        $xdata["data"]=array($data["data"]);
                    }                    
                }
                
                
                
                $progress->setData(json_encode($xdata));
                $progress->setPos($progress->getPos()+$num);
                $progress->setRequestStop($requestStop);
                
                $this->em->persist($progress);
                $this->em->flush();
                
            }
            
            return $progress;
        }
        
        return null;
    }
    
        
    /**
     * 
     * @param string $uid
     * @return Progress
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
    
    /**
     * 
     * @param string $uid
     * @return Progress
     */
    public function requestStopProgress($uid) {
        if ($uid!=null) {
            $progress=$this->caricaDaUid($uid);
            /*@var $progress Progress  */

            if ($progress) {
                
                $progress->setRequestStop(true);
                
                $this->em->persist($progress);
                $this->em->flush();
                
            }
            
            return $progress;
        }
        
        return null;
    }
    
    
    
    /**
     * 
     * @param string $uid
     * @return Progress
     */
    public function requestStopDoneProgress($uid) {
        if ($uid!=null) {
            $progress=$this->caricaDaUid($uid);
            /*@var $progress Progress  */

            if ($progress) {
                
                $progress->setRequestStopDone(true);
                
                $this->em->persist($progress);
                $this->em->flush();
                
            }
            
            return $progress;
        }
        
        return null;
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
                'stoppedRequestStop' => $progress->getRequestStop(),
                'stoppedRequestStopDone' => $progress->getRequestStopDone(),
                'data' => json_decode($progress->getData(),true)
            );
            
            
            $progress->setData('');
            $this->em->persist($progress);
            $this->em->flush();            
            
            
            if ($progress->getRequestStopDone()) {
                $this->quitProgress($uid);
            }
            
        } else {
            // not yet created ... quite strange
            $res=array(
                'max' => 1,
                'progress' => 0,
                'stoppedRequestStop' => false,
                'stoppedRequestStopDone' => false,
                'data' => ''
            );
        }
        
        return $res;
    }
        
}



