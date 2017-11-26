<?php
namespace AppBundle\Controller;

use AppBundle\Form\Type\DeleteType;
use AppBundle\Model\ResourceInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ResourceController
 *
 * @package AppBundle\Controller
 */
class ResourceController extends BaseController
{
    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $resourceClass = $request->get('_entity');
        if (null === $resourceClass || !class_exists($resourceClass)) {
            throw $this->entityNotFound($resourceClass, null);
        }

        $resources = $this->getRepository($request->get('_entity'))->findAll();

        return $this->render('@App/CRUD/list.html.twig', [
            'resources' => $resources
        ]);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param                                           $id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Request $request, $id)
    {
        $resourceClass = $request->get('_entity');
        if (null === $resourceClass || !class_exists($resourceClass)) {
            throw $this->entityNotFound($resourceClass, $id);
        }

        $resource = $this->getRepository($request->get('_entity'))->find($id);
        if (!$resource instanceof ResourceInterface) {
            throw $this->entityNotFound($resourceClass, $id);
        }

        return $this->render('@App/CRUD/show.html.twig', [
            'resource' => $resource
        ]);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        $formClass = $request->get('_form');

        if (null === $formClass || !class_exists($formClass)) {
            throw $this->formNotFound($formClass);
        }

        $form = $this->createForm($formClass, null, [ 'method' => Request::METHOD_POST ]);
        if ($form->handleRequest($request)->isSubmitted() && $form->isValid()) {
            $this->update($form->getData());

            return $this->redirectToRoute($request->get('_route'));
        }

        return $this->render('@App/CRUD/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param                                           $id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, $id)
    {
        $resourceClass = $request->get('_entity');
        $formClass     = $request->get('_form');

        if (null === $resourceClass || !class_exists($resourceClass)) {
            throw $this->entityNotFound($resourceClass, $id);
        }
        if (null === $formClass || !class_exists($formClass)) {
            throw $this->formNotFound($formClass);
        }

        $resource = $this->getRepository($resourceClass)->find($id);
        if (!$resource instanceof ResourceInterface) {
            throw $this->entityNotFound($resourceClass, $id);
        }

        $form   = $this->createForm($formClass, $resource, [ 'method' => Request::METHOD_PUT ]);
        if ($form->handleRequest($request)->isSubmitted() && $form->isValid()) {
            $this->update($form->getData());

            return $this->redirectToRoute($request->get('_route'), [ 'id' => $id ]);
        }

        return $this->render('@App/CRUD/update.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param                                           $id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction(Request $request, $id)
    {
        $resourceClass = $request->get('_entity');

        if (null === $resourceClass || !class_exists($resourceClass)) {
            throw $this->entityNotFound($resourceClass, $id);
        }

        $resource = $this->getRepository($resourceClass)->find($id);
        if (!$resource instanceof ResourceInterface) {
            throw $this->entityNotFound($resourceClass, $id);
        }

        $form   = $this->createForm(DeleteType::class, $resource, [ 'method' => Request::METHOD_DELETE ]);
        if ($form->handleRequest($request)->isSubmitted() && $form->isValid()) {
            $this->remove($form->getData());

            return $this->redirectToRoute($request->get('_route'));
        }

        return $this->render('@App/CRUD/delete.html.twig', []);
    }
}
