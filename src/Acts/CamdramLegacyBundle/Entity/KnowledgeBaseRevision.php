<?php

namespace Acts\CamdramLegacyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * KnowledgeBaseRevision
 *
 * @ORM\Table(name="acts_knowledgebase")
 * @ORM\Entity
 */
class KnowledgeBaseRevision
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="pageid", type="integer", nullable=true)
     */
    private $page_id;

    /**
     * @var \Page
     *
     * @ORM\ManyToOne(targetEntity="Page", inversedBy="revisions")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="pageid", referencedColumnName="id")
     * })
     */
    private $page;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="text", nullable=false)
     */
    private $text;

    /**
     * @var int
     *
     * @ORM\Column(name="userid", type="integer", nullable=true)
     */
    private $user_id;

    /**
     * @var \Acts\CamdramSecurityBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="\Acts\CamdramSecurityBundle\Entity\User", inversedBy="knowledge_base_revisions")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="userid", referencedColumnName="id")
     * })
     */
    private $user;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    private $date;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get page_id
     *
     * @return int
     */
    public function getPageId()
    {
        return $this->page_id;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Get user_id
     *
     * @return int
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Get page
     *
     * @return \Acts\CamdramLegacyBundle\Entity\Page
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Get user
     *
     * @return \Acts\CamdramSecurityBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set page_id
     *
     * @param int $pageId
     *
     * @return KnowledgeBaseRevision
     */
    public function setPageId($pageId)
    {
        $this->page_id = $pageId;

        return $this;
    }

    /**
     * Set text
     *
     * @param string $text
     *
     * @return KnowledgeBaseRevision
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Set user_id
     *
     * @param int $userId
     *
     * @return KnowledgeBaseRevision
     */
    public function setUserId($userId)
    {
        $this->user_id = $userId;

        return $this;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return KnowledgeBaseRevision
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Set page
     *
     * @param \Acts\CamdramLegacyBundle\Entity\Page $page
     *
     * @return KnowledgeBaseRevision
     */
    public function setPage(\Acts\CamdramLegacyBundle\Entity\Page $page = null)
    {
        $this->page = $page;

        return $this;
    }

    /**
     * Set user
     *
     * @param \Acts\CamdramSecurityBundle\Entity\User $user
     *
     * @return KnowledgeBaseRevision
     */
    public function setUser(\Acts\CamdramSecurityBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }
}
