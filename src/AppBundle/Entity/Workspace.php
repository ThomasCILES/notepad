<?php
/**
 * User: thomas
 * Date: 26/11/17
 * Time: 11:09
 */

namespace AppBundle\Entity;

use AppBundle\Model\ResourceInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * Class Workspace
 * @package AppBundle\Entity
 * @ORM\Entity()
 */
class Workspace implements ResourceInterface
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Cluster", mappedBy="workspace", cascade={"remove", "refresh", "persist"})
     */
    protected $clusters;

    /**
     * Workspace constructor.
     */
    public function __construct()
    {
        $this->clusters = new ArrayCollection();
    }

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    protected $title;

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Add cluster
     *
     * @param \AppBundle\Entity\Cluster $cluster
     *
     * @return Workspace
     */
    public function addCluster(\AppBundle\Entity\Cluster $cluster)
    {
        $cluster->setWorkspace($this);
        $this->clusters[] = $cluster;

        return $this;
    }

    /**
     * Remove cluster
     *
     * @param \AppBundle\Entity\Cluster $cluster
     */
    public function removeCluster(\AppBundle\Entity\Cluster $cluster)
    {
        $this->clusters->removeElement($cluster);
    }

    /**
     * Get clusters
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getClusters()
    {
        return $this->clusters;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }
}
