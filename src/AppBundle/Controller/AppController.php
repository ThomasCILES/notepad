<?php
namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;

/**
 * Class ResourceController
 *
 * @package AppBundle\Controller
 */
class AppController extends BaseController
{
    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        return $this->render('default/index.html.twig');
    }
}
