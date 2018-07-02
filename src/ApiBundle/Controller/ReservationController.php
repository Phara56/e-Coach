<?php


namespace ApiBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations
use FOS\RestBundle\View\ViewHandler;
use FOS\RestBundle\View\View; // Utilisation de la vue de FOSRestBundle
use AppBundle\Entity\Reservation;
use Nelmio\ApiDocBundle\Annotation as Doc;


class ReservationController extends Controller
{

    /**
     * @Rest\View()
     * @Rest\Get("/reservations")
     *
     *
     * @Doc\ApiDoc(
     *     section="Reservations",
     *     resource=true,
     *     description="Get the list of all reservations."
     * )
     */
    public function getReservationsAction(Request $request)
    {
        $reservations = $this->get('doctrine.orm.entity_manager')
            ->getRepository('AppBundle:Reservation')
            ->findAll();
        /* @var $reservations Reservation[] */

        return $reservations;
    }

    /**
     * @Rest\View()
     * @Rest\Get("/reservations/{id}")
     *
     * @Doc\ApiDoc(
     *     section="Reservations",
     *     resource=true,
     *     description="Get one reservations.",
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

    public function getReservationAction($id,Request $request)
    {

        $reservation=$this->get('doctrine.orm.entity_manager')
            ->getRepository('AppBundle:Reservation')
            ->find($id);


        if (empty($reservation)) {
            return new JsonResponse(array('message' => 'reservation not found'), Response::HTTP_NOT_FOUND);
        }

        return $reservation;
    }
    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED)
     * @Rest\Post("/reservations")
     * @Doc\ApiDoc(
     *     section="Reservations",
     *     resource=true,
     *     description="Post reservations.",
     *     statusCodes={
     *         201="Returned when created",
     *         400="Returned when a violation is raised by validation"
     *     }
     *
     * )
     */
    public function postReservationsAction(Request $request)
    {
        $reservation = new Reservation();
        $form = $this->createForm('AppBundle\Form\Type\ReservationType',$reservation);
        $form->submit($request->request->all());

        if ($form -> isValid()){
            $em=$this->get('doctrine.orm.entity_manager');
            $em->persist($reservation);
            $em->flush();
            return $reservation;
        }else{
            return $form;
        }
    }
    /**
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     * @Rest\Delete("/reservations/{id}")
     *  @Doc\ApiDoc(
     *     section="Reservations",
     *     resource=true,
     *     description="remove reservation.",
     *     statusCodes={
     *         201="Returned when created",
     *         400="Returned when a violation is raised by validation"
     *     }
     *
     * )
     */
    public function removeReservationsAction(Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $reservation = $em->getRepository('AppBundle:Reservation')
            ->find($request->get('id'));
        /* @var $reservation Reservation */

        if ($reservation) {
            $em->remove($reservation);
            $em->flush();
        }

    }


}