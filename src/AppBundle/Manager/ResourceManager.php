<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 26/11/17
 * Time: 15:00
 */

namespace AppBundle\Manager;


use AppBundle\Model\ResourceInterface;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class ResourceManager
 *
 * @package AppBundle\Manager
 */
class ResourceManager implements ResourceManagerInterface
{
    /**
     * @var \Doctrine\ORM\EntityManagerInterface
     */
    protected $manager;

    /**
     * ResourceManager constructor.
     *
     * @param \Doctrine\ORM\EntityManagerInterface $manager
     */
    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @inheritdoc
     */
    public function update(ResourceInterface $resource)
    {
        $this->manager->persist($resource);
        $this->manager->flush();
    }

    /**
     * @inheritdoc
     */
    public function remove(ResourceInterface $resource)
    {
        $this->manager->remove($resource);
        $this->manager->flush();
    }
}