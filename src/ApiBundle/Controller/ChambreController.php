<?php
namespace ApiBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations
use FOS\RestBundle\View\ViewHandler;
use FOS\RestBundle\View\View; // Utilisation de la vue de FOSRestBundle
use AppBundle\Entity\Chambre;
use AppBundle\Form\Type\ChambreType;
use Nelmio\ApiDocBundle\Annotation as Doc;

class ChambreController extends Controller
{

    /**
     * @Rest\View()
     * @Rest\Get("/chambres")
     *
     *
     * @Doc\ApiDoc(
     *     section="Chambres",
     *     resource=true,
     *     description="Get the list of all chambre."
     * )
     */
    public function getChambresAction(Request $request)
    {
        $chambres =$this->get('doctrine.orm.entity_manager')
            ->getRepository('AppBundle:Chambre')
            ->findAll();
        /* @var $chambre Chambres[]*/

        return $chambres;
    }



    /**
     * @Rest\View()
     * @Rest\Get("/chambres/{id}")
     *
     * @Doc\ApiDoc(
     *     section="Chambres",
     *     resource=true,
     *     description="Get one chambre.",
     *     requirements={
     *         {
     *             "name"="id",
     *             "dataType"="integer",
     *             "requirements"="\d+",
     *             "description"="The article unique identifier."
     *         }
     *     }
     * )
     */

    public function getChambreAction($id,Request $request)
    {

        $chambre=$this->get('doctrine.orm.entity_manager')
            ->getRepository('AppBundle:Chambre')
            ->find($id);


        if (empty($chambre)) {
            return new JsonResponse(array('message' => 'Chambre not found'), Response::HTTP_NOT_FOUND);
        }

        return $chambre;
    }
    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED)
     * @Rest\Post("/chambres")
     * @Doc\ApiDoc(
     *     section="Chambres",
     *     resource=true,
     *     description="Post chambre.",
     *     statusCodes={
     *         201="Returned when created",
     *         400="Returned when a violation is raised by validation"
     *     }
     *
     * )
     */
    public function postChambresAction(Request $request)
    {
        $chambre = new Chambre();
        $form = $this->createForm('AppBundle\Form\Type\ChambreType',$chambre);
        $form->submit($request->request->all());

        if ($form -> isValid()){
            $em=$this->get('doctrine.orm.entity_manager');
            $em->persist($chambre);
            $em->flush();
            return $chambre;
        }else{
            return $form;
        }
    }
    /**
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     * @Rest\Delete("/chambres/{id}")
     *  @Doc\ApiDoc(
     *     section="Chambres",
     *     resource=true,
     *     description="remove chambre.",
     *     statusCodes={
     *         201="Returned when created",
     *         400="Returned when a violation is raised by validation"
     *     }
     *
     * )
     */
    public function removeChambreAction(Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $chambre = $em->getRepository('AppBundle:Chambre')
            ->find($request->get('id'));
        /* @var $chambre Chambre */

        if ($chambre) {
            $em->remove($chambre);
            $em->flush();
        }

    }
    /**
     * @Rest\View()
     * @Rest\Put("/chambres/{id}")
     *  @Doc\ApiDoc(
     *     section="Chambres",
     *     resource=true,
     *     description="update chambre."
     *
     * )
     */
    public function patchPlaceAction(Request $request)
    {
        return $this->updateChambre($request, false);
    }
   private function updateChambre(Request $request)
    {
        $chambre = $this->get('doctrine.orm.entity_manager')
            ->getRepository('AppBundle:Chambre')
            ->find($request->get('id')); // L'identifiant en tant que paramètre n'est plus nécessaire
        /* @var $chambre Chambre */

        if (empty($chambre)) {
            return new JsonResponse(array('message' => 'Place not found'), Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm('ApiBundle\Form\Type\ChambreType',$chambre);
        $form->submit($request->request->all());
        if ($form->isValid()) {
            $em = $this->get('doctrine.orm.entity_manager');
            $em->persist($chambre);
            $em->flush();
            return $chambre;
        } else {
            return $form;
        }

    }
}