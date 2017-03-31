<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Species;

/**
 * @Route("/species")
 */
class SpeciesController extends Controller
{

    /**
     * @Route("/")
     *
     * @method ("GET")
     */
    public function indexAction()
    {
        return $this->render('AppBundle:Species:index.html.twig',
                [
                    'entities' => $this->getDoctrine()
                        ->getRepository('AppBundle:Species')
                        ->findAll()
                ]);
    }

    /**
     * @Route("/{id}/edit", requirements={"id"="^\d+$"})
     */
    public function editAction(Request $request, Species $entity)
    {
        return $this->change($request, 'AppBundle:Species:edit.html.twig', $entity);
    }

    /**
     * @Route("/new")
     */
    public function newAction(Request $request)
    {
        return $this->change($request, 'AppBundle:Species:new.html.twig', new Species());
    }

    /**
     * @Route("/{id}/delete", requirements={"id":"^\d+"})
     * @Method("GET")
     */
    public function deleteAction(Species $species)
    {
        $manager = $this->getDoctrine()->getManager();

        $manager->remove($species);
        $manager->flush();

        return $this->redirectToRoute('app_species_index');
    }

    /**
     * New or update.
     *
     * @param Request $request
     * @param string $template
     * @param Animal $entity
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    protected function change(Request $request, string $template, Species $entity)
    {
        $formBuilder = $this->createFormBuilder($entity);

        $formBuilder->add('name');

        $formBuilder->add('submit', 'submit');
        $formBuilder->add('submitAndAddNew', 'submit');

        $form = $formBuilder->getForm();

        if ($request->getMethod() === 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $doctrine = $this->getDoctrine();
                $manager = $doctrine->getManager();

                $manager->persist($entity);
                $manager->flush();

                switch ($form->getClickedButton()->getName()) {
                    default:
                    case 'submit':
                        $link = 'app_species_index';
                        break;
                    case 'submitAndAddNew':
                        $link = 'app_species_new';
                        break;
                }

                return $this->redirectToRoute($link);
            }
        }

        return $this->render($template, [
            'form' => $form->createView()
        ]);
    }
}
