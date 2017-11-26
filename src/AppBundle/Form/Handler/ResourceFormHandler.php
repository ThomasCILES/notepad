<?php

namespace AppBundle\Form\Handler;
use AppBundle\Manager\ResourceManagerInterface;
use AppBundle\Model\ResourceInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class ResourceFormHandler
 *
 * @package AppBundle\Form\Handler
 */
class ResourceFormHandler
{
    /**
     * @var \Symfony\Component\HttpFoundation\RequestStack
     */
    protected $requestStack;

    /**
     * @var \AppBundle\Manager\ResourceManagerInterface
     */
    protected $resourceManager;

    /**
     * @var \Symfony\Component\Routing\RouterInterface
     */
    protected $router;

    /**
     * ResourceFormHandler constructor.
     *
     * @param \Symfony\Component\HttpFoundation\RequestStack $requestStack
     * @param \AppBundle\Manager\ResourceManagerInterface    $resourceManager
     * @param \Symfony\Component\Routing\RouterInterface     $router
     */
    public function __construct(
        RequestStack $requestStack,
        ResourceManagerInterface $resourceManager,
        RouterInterface $router
    )
    {
        $this->requestStack     = $requestStack;
        $this->resourceManager  = $resourceManager;
        $this->router           = $router;
    }

    /**
     * @param \Symfony\Component\Form\FormInterface $form
     *
     * @return bool
     */
    public function handle(FormInterface $form)
    {
        if ($form->handleRequest($this->getCurrentRequest())->isSubmitted() && $form->isValid()) {
            return $this->process($form->getData());
        }

        return false;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function getResponse()
    {
        $route      = $this->getRoute();
        $parameters = $this->getParameters($route);

        return new RedirectResponse($this->router->generate($route, $parameters));
    }

    /**
     * @return mixed
     */
    protected function getRoute()
    {
        $request = $this->getCurrentRequest();
        return $request->get('_redirect', $request->get('_route'));
    }

    /**
     * @param $route
     *
     * @return array
     */
    protected function getParameters($route)
    {
        $requirements = $this->router->getRouteCollection()->get($route)->getRequirements();
        $id  = $this->getCurrentRequest()->get('id');

        return (!empty($requirements['id'])) ? ['id' => $id] : [];
    }

    /**
     * @param \AppBundle\Model\ResourceInterface $resource
     *
     * @return bool
     */
    protected function process(ResourceInterface $resource)
    {
        $httpMethod = $this->getCurrentRequest()->getMethod();

        switch($httpMethod) {
            case Request::METHOD_DELETE:
                $this->resourceManager->remove($resource);
                break;
            default:
                $this->resourceManager->update($resource);
        }

        return true;
    }

    /**
     * @return null|\Symfony\Component\HttpFoundation\Request
     */
    protected function getCurrentRequest()
    {
        return $this->requestStack->getCurrentRequest();
    }
}