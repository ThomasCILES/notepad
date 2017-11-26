<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Cluster;
use AppBundle\Entity\Note;
use AppBundle\Entity\Workspace;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation as Doc;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ResourceController
 *
 * @package AppBundle\Controller
 */
class ApiController extends Controller
{
    /**
     * @Rest\Post("/workspaces/new")
     *
     * @param \FOS\RestBundle\Request\ParamFetcher $fetcher
     * @RequestParam(name="title")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postWorkspaceAction(ParamFetcher $fetcher)
    {
        $workspace = new Workspace();
        $workspace->setTitle($fetcher->get('title'));

        $em = $this->getDoctrine()->getManager();
        $em->persist($workspace);
        $em->flush();

        $view = View::create()
            ->setStatusCode(Response::HTTP_CREATED);
        return $this->getViewHandler()->handle($view);
    }

    /**
     * @Doc\ApiDoc(
     *     section="Workspaces",
     *     resource=true,
     *     description="Get the list of workspaces",
     *     statusCodes={
     *         200="Returned when successful"
     *     }
     * )
     */
    public function getWorkspacesAction()
    {
        $view = View::create()
            ->setData($this->getDoctrine()->getRepository(Workspace::class)->findAll());
        return $this->getViewHandler()->handle($view);
    }

    /**
     * @Doc\ApiDoc(
     *     section="Workspaces",
     *     resource=true,
     *     description="Get workspace",
     *     statusCodes={
     *         200="Returned when successful"
     *     }
     * )
     * @param $id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getWorkspaceAction($id)
    {
        $view = View::create()
            ->setData($this->getDoctrine()->getRepository(Workspace::class)->find($id));
        return $this->getViewHandler()->handle($view);
    }

    /**
     * @Doc\ApiDoc(
     *     section="Clusters",
     *     resource=true,
     *     description="Get the list of clusters",
     *     statusCodes={
     *         200="Returned when successful"
     *     }
     * )
     */
    public function getClustersAction()
    {
        $view = View::create()
            ->setData($this->getDoctrine()->getRepository(Cluster::class)->findAll());
        return $this->getViewHandler()->handle($view);
    }

    /**
     * @Doc\ApiDoc(
     *     section="Clusters",
     *     resource=true,
     *     description="Get cluster",
     *     statusCodes={
     *         200="Returned when successful"
     *     }
     * )
     * @param $id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getClusterAction($id)
    {
        $view = View::create()
            ->setData($this->getDoctrine()->getRepository(Cluster::class)->find($id));
        return $this->getViewHandler()->handle($view);
    }

    /**
     * @Doc\ApiDoc(
     *     section="Notes",
     *     resource=true,
     *     description="Get the list of notes",
     *     statusCodes={
     *         200="Returned when successful"
     *     }
     * )
     */
    public function getNotesAction()
    {
        $view = View::create()
            ->setData($this->getDoctrine()->getRepository(Note::class)->findAll());
        return $this->getViewHandler()->handle($view);
    }

    /**
     * @Doc\ApiDoc(
     *     section="Notes",
     *     resource=true,
     *     description="Get note",
     *     statusCodes={
     *         200="Returned when successful"
     *     }
     * )
     * @param                                           $id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getNoteAction($id)
    {
        $view = View::create()
            ->setData($this->getDoctrine()->getRepository(Note::class)->find($id));

        return $this->getViewHandler()->handle($view);
    }

    /**
     * @return \FOS\RestBundle\View\ViewHandler
     */
    private function getViewHandler()
    {
        return $this->container->get('fos_rest.view_handler');
    }
}
