<?php
/**
 * User: thomas
 * Date: 26/11/17
 * Time: 11:09
 */
namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Note
 *
 * @ORM\Table(name="note")
 * @ORM\Entity()
 */
class Note
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
     * @var \Doctrine\Common\Collections\ArrayCollection
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Cluster", inversedBy="notes", orphanRemoval=true)
     */
    protected $clusters;

    /**
     * Note constructor.
     */
    public function __construct()
    {
        $this->clusters = new ArrayCollection();
    }

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
     * Add cluster
     *
     * @param \AppBundle\Entity\Cluster $cluster
     *
     * @return Note
     */
    public function addCluster(\AppBundle\Entity\Cluster $cluster)
    {
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
}
