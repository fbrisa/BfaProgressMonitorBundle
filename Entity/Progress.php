<?php

namespace Bfa\ProgressMonitorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Index;

/**
 * Progress
 *
 * @ORM\Table(name="bfa_progress",indexes={@Index(name="bfaprogressuid_idx", columns={"uid"})},options={"engine"="Memory"})
 * @ORM\Entity
 */
class Progress
{
    
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var datetime $data
     *
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $dataCreazione;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    private $max=0;
    
    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    private $pos=0;
    
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $uid="";
    
    
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=1024, nullable=false)
     */
    private $data="";
    
    /**
     * @ORM\Column(type="boolean", options={"default": false}, nullable=false)
     */
    protected $requestStop = false;
    
    /**
     * @ORM\Column(type="boolean", options={"default": false}, nullable=false)
     */
    protected $requestStopDone = false;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->dataCreazione=new \DateTime();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * Set max
     *
     * @param integer $max
     *
     * @return Progress
     */
    public function setMax($max)
    {
        $this->max = $max;

        return $this;
    }

    /**
     * Get max
     *
     * @return integer
     */
    public function getMax()
    {
        return $this->max;
    }

    

    /**
     * Set uid
     *
     * @param string $uid
     *
     * @return Progress
     */
    public function setUid($uid)
    {
        $this->uid = $uid;

        return $this;
    }

    /**
     * Get uid
     *
     * @return string
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * Set pos
     *
     * @param integer $pos
     *
     * @return Progress
     */
    public function setPos($pos)
    {
        $this->pos = $pos;

        return $this;
    }

    /**
     * Get pos
     *
     * @return integer
     */
    public function getPos()
    {
        return $this->pos;
    }

    /**
     * Set append
     *
     * @param string $append
     *
     * @return Progress
     */
    public function setAppend($append)
    {
        $this->append = $append;

        return $this;
    }

    /**
     * Get append
     *
     * @return string
     */
    public function getAppend()
    {
        return $this->append;
    }

    /**
     * Set dataCreazione
     *
     * @param \DateTime $dataCreazione
     *
     * @return Progress
     */
    public function setDataCreazione($dataCreazione)
    {
        $this->dataCreazione = $dataCreazione;

        return $this;
    }

    /**
     * Get dataCreazione
     *
     * @return \DateTime
     */
    public function getDataCreazione()
    {
        return $this->dataCreazione;
    }

    /**
     * Set data
     *
     * @param string $data
     *
     * @return Progress
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get data
     *
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set requestStop
     *
     * @param boolean $requestStop
     *
     * @return Progress
     */
    public function setRequestStop($requestStop)
    {
        $this->requestStop = $requestStop;

        return $this;
    }

    /**
     * Get requestStop
     *
     * @return boolean
     */
    public function getRequestStop()
    {
        return $this->requestStop;
    }

    /**
     * Set requestStopDone
     *
     * @param boolean $requestStopDone
     *
     * @return Progress
     */
    public function setRequestStopDone($requestStopDone)
    {
        $this->requestStopDone = $requestStopDone;

        return $this;
    }

    /**
     * Get requestStopDone
     *
     * @return boolean
     */
    public function getRequestStopDone()
    {
        return $this->requestStopDone;
    }
}
