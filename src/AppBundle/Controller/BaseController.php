<?php

namespace AppBundle\Controller;

use AppBundle\Model\ResourceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class ResourceController
 *
 * @package AppBundle\Controller
 */
class BaseController extends Controller
{
    /**
     * @return \Doctrine\Common\Persistence\ObjectManager
     */
    protected function getManager()
    {
        return $this->getDoctrine()->getManager();
    }

    /**
     * @param $resource
     *
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    protected function getRepository($resource)
    {
        if ($resource instanceof ResourceInterface) {
            $resource = get_class($resource);
        }
        return $this->getDoctrine()->getRepository($resource);
    }

    /**
     * @param \AppBundle\Model\ResourceInterface $resource
     */
    protected function update(ResourceInterface $resource)
    {
        $em = $this->getManager();
        $em->persist($resource);
        $em->flush();
    }

    /**
     * @param \AppBundle\Model\ResourceInterface $resource
     */
    protected function remove(ResourceInterface $resource)
    {
        $em = $this->getManager();
        $em->remove($resource);
        $em->flush();
    }

    /**
     * @param       $id
     * @param array $parameters
     * @param null  $domain
     * @param null  $locale
     *
     * @return string
     */
    protected function trans($id, array $parameters = [], $domain = null, $locale = null)
    {
        return $this->get('translator')->trans($id, $parameters, $domain, $locale);
    }

    /**
     * @param $entity
     * @param $id
     *
     * @return \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    protected function entityNotFound($entity, $id)
    {
        return $this->createNotFoundException($this->trans('app.error.entity.not_found', [
            '%entity%' => $entity,
            '%id%'     => $id
        ]));
    }

    /**
     * @param $form
     *
     * @return \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    protected function formNotFound($form)
    {
        return $this->createNotFoundException($this->trans('app.error.form.not_found', [
            '%form%' => $form
        ]));
    }
}
