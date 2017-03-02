<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Animal;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * @Route("/animal")
 */
class AnimalController extends Controller
{

    /**
     * @Route("/")
     */
    public function indexAction()
    {
        $doctrine = $this->getDoctrine();
        $repository = $doctrine->getRepository('AppBundle:Animal');

        $animals = $repository->findAll();

        return $this->render('AppBundle:Animal:index.html.twig', [
            'entities' => $animals
        ]);
    }

    /**
     * @Route("/new")
     */
    public function newAction(Request $request)
    {
        $entity = new Animal();

        return $this->change($request, 'AppBundle:Animal:new.html.twig', $entity);
    }

    /**
     * @Route("/{id}/edit", requirements={"id"="^\d+$"})
     */
    public function editAction(Request $request, Animal $entity)
    {
        return $this->change($request, 'AppBundle:Animal:edit.html.twig', $entity);
    }

    /**
     * @Route("/{id}/delete", requirements={"id"="^\d+$"})
     * @Method("POST")
     */
    public function deleteAction(Animal $animal)
    {
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($animal);
        $manager->flush();

        return $this->redirectToRoute('app_animal_index');
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
    protected function change(Request $request, string $template, Animal $entity)
    {
        $formBuilder = $this->createFormBuilder($entity);

        $formBuilder->add('name', null, [
            'label' => 'Surname'
        ]);
        $formBuilder->add('weight', null, [
            'required' => true
        ]);
        $formBuilder->add('birthdate', null, [
            'widget' => 'single_text'
        ]);
        $formBuilder->add('species');

        $formBuilder->add('submit', 'submit');

        $form = $formBuilder->getForm();

        if ($request->getMethod() === 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $doctrine = $this->getDoctrine();
                $manager = $doctrine->getManager();

                $manager->persist($entity);
                $manager->flush();

                return $this->redirectToRoute('app_animal_index');
            }
        }

        return $this->render($template,
                [
                    'form' => $form->createView()
                ]);
    }
}
