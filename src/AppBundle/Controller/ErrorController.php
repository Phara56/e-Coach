<?php
/**
 * Created by PhpStorm.
 * User: PC-Guillaume
 * Date: 27/06/2018
 * Time: 11:38
 */

namespace AppBundle\Controller;
use AppBundle\Entity\User;
use FOS\UserBundle\Controller\RegistrationController as BaseController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Response;

/**
 * User controller.
 *
 * @Route("/error")
 */
class ErrorController extends Controller
{
    /**
     * @Route("/")
     * @Template("AppBundle:Error:index.html.twig")
     */
    public function indexAction(Request $request)
    {

    }
}