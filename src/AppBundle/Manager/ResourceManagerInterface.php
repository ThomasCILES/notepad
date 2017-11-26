<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 26/11/17
 * Time: 15:01
 */

namespace AppBundle\Manager;

use AppBundle\Model\ResourceInterface;

/**
 * Interface ResourceManagerInterface
 *
 * @package AppBundle\Manager
 */
interface ResourceManagerInterface
{
    /**
     * @param \AppBundle\Model\ResourceInterface $resource
     */
    public function update(ResourceInterface $resource);

    /**
     * @param \AppBundle\Model\ResourceInterface $resource
     */
    public function remove(ResourceInterface $resource);
}