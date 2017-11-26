<?php
/**
 * User: thomas
 * Date: 26/11/17
 * Time: 11:14
 */

namespace AppBundle\Entity;
use AppBundle\Model\ResourceInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Cluster
 *
 * @package AppBundle\Entity
 * @ORM\Entity()
 */
class Cluster implements ResourceInterface
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
     * @var \AppBundle\Entity\Workspace
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Workspace", inversedBy="clusters")
     */
    protected $workspace;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Note", mappedBy="clusters", cascade={"remove", "refresh", "persist"})
     */
    protected $notes;

    /**
     * Cluster constructor.
     */
    public function __construct()
    {
        $this->notes = new ArrayCollection();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Add note
     *
     * @param \AppBundle\Entity\Note $note
     *
     * @return Cluster
     */
    public function addNote(Note $note)
    {
        $this->notes[] = $note;

        return $this;
    }

    /**
     * Remove note
     *
     * @param \AppBundle\Entity\Note $note
     */
    public function removeNote(Note $note)
    {
        $this->notes->removeElement($note);
    }

    /**
     * Get notes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Set workspace
     *
     * @param \AppBundle\Entity\Workspace $workspace
     *
     * @return Cluster
     */
    public function setWorkspace(Workspace $workspace = null)
    {
        $this->workspace = $workspace;

        return $this;
    }

    /**
     * Get workspace
     *
     * @return \AppBundle\Entity\Workspace
     */
    public function getWorkspace()
    {
        return $this->workspace;
    }
}
