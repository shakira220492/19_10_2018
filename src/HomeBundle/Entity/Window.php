<?php

namespace HomeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Window
 *
 * @ORM\Table(name="window", indexes={@ORM\Index(name="user_id", columns={"user_id"})})
 * @ORM\Entity
 */
class Window
{
    /**
     * @var integer
     *
     * @ORM\Column(name="window_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $windowId;

    /**
     * @var float
     *
     * @ORM\Column(name="window_videoSpeed", type="float", precision=10, scale=0, nullable=false)
     */
    private $windowVideospeed;

    /**
     * @var string
     *
     * @ORM\Column(name="window_geolocalization", type="string", length=20, nullable=true)
     */
    private $windowGeolocalization;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="user_id")
     * })
     */
    private $user;



    /**
     * Get windowId
     *
     * @return integer
     */
    public function getWindowId()
    {
        return $this->windowId;
    }

    /**
     * Set windowVideospeed
     *
     * @param float $windowVideospeed
     *
     * @return Window
     */
    public function setWindowVideospeed($windowVideospeed)
    {
        $this->windowVideospeed = $windowVideospeed;

        return $this;
    }

    /**
     * Get windowVideospeed
     *
     * @return float
     */
    public function getWindowVideospeed()
    {
        return $this->windowVideospeed;
    }

    /**
     * Set windowGeolocalization
     *
     * @param string $windowGeolocalization
     *
     * @return Window
     */
    public function setWindowGeolocalization($windowGeolocalization)
    {
        $this->windowGeolocalization = $windowGeolocalization;

        return $this;
    }

    /**
     * Get windowGeolocalization
     *
     * @return string
     */
    public function getWindowGeolocalization()
    {
        return $this->windowGeolocalization;
    }

    /**
     * Set user
     *
     * @param \HomeBundle\Entity\User $user
     *
     * @return Window
     */
    public function setUser(\HomeBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \HomeBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
