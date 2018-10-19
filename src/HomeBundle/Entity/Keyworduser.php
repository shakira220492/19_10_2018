<?php

namespace HomeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Keyworduser
 *
 * @ORM\Table(name="keywordUser", indexes={@ORM\Index(name="keyword_id", columns={"keyword_id"}), @ORM\Index(name="user_id", columns={"user_id"})})
 * @ORM\Entity
 */
class Keyworduser
{
    /**
     * @var integer
     *
     * @ORM\Column(name="keywordUser_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $keyworduserId;

    /**
     * @var \Keyword
     *
     * @ORM\ManyToOne(targetEntity="Keyword")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="keyword_id", referencedColumnName="keyword_id")
     * })
     */
    private $keyword;

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
     * Get keyworduserId
     *
     * @return integer
     */
    public function getKeyworduserId()
    {
        return $this->keyworduserId;
    }

    /**
     * Set keyword
     *
     * @param \HomeBundle\Entity\Keyword $keyword
     *
     * @return Keyworduser
     */
    public function setKeyword(\HomeBundle\Entity\Keyword $keyword = null)
    {
        $this->keyword = $keyword;

        return $this;
    }

    /**
     * Get keyword
     *
     * @return \HomeBundle\Entity\Keyword
     */
    public function getKeyword()
    {
        return $this->keyword;
    }

    /**
     * Set user
     *
     * @param \HomeBundle\Entity\User $user
     *
     * @return Keyworduser
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
