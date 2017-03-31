<?php
namespace AppBundle\Controller\Front;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class RestSpeciesController extends Controller
{

    /**
     * Gets all species from database.
     *
     * @Route("/rest/species")
     *
     * @method ("GET")
     */
    public function getAllAction()
    {
        $entities = $this->getRepo()->findAll();

        $entities = $this->get('serializer')->serialize($entities, 'json');

        return new Response($entities);
    }

    /**
     * Gets the repository.
     *
     * @return \Doctrine\ORM\EntityRepository
     */
    protected function getRepo()
    {
        return $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Species');
    }
}
