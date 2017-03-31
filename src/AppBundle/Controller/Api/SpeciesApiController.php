<?php
namespace AppBundle\Controller\Api;

use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\SpeciesType;
use AppBundle\Entity\Species;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Rest\NamePrefix("api_app_species_")
 * @Rest\Prefix("/species")
 */
class SpeciesApiController extends FOSRestController
{

    /**
     * @Rest\Get("/list")
     * @ApiDoc(
     * section="Species",
     * resource=true,
     * description="Gets all species."
     * )
     */
    public function getAllAction()
    {
        $data = $this->getRepo()->findAll();

        $view = $this->view($data)
            ->setTemplate('AppBundle:Species:index.html.twig')
            ->setTemplateData(['entities' => $data]);

        return $this->handleView($view);
    }

    /**
     * @Rest\Post("/create")
     *
     * @ApiDoc(
     * section="Species",
     * resource=true,
     * description="Create a new species into database.",
     * input={"class": "AppBundle\Form\SpeciesType", "name": ""},
     * requirements={},
     * parameters={
     *     {
     *         "name"="name",
     *         "dataType"="string",
     *         "description"="The name of the species to add."
     *     }
     * },
     * statusCodes={
     *     201="The species was insert into database.",
     *     400="Error, see form errors for details."
     * }
     * )
     */
    public function createAction(Request $request)
    {
        $view = null;
        $entity = new Species();
        $form = $this->createForm(SpeciesType::class, $entity);

        $form->submit($request->request->all());

        if ($entity->getName() == '') {
            $form->addError(new FormError('Name cannot be empty'));
        }

        if ($form->isValid()) {
            $manager = $this->getDoctrine()->getManager();

            $manager->persist($entity);
            $manager->flush();

            $view = $this->view($entity, Response::HTTP_CREATED);
        } else {
            $view = $this->view($form);
        }

        return $this->handleView($view);
    }

    /**
     * @Rest\Get("/{id}")
     *
     * @ApiDoc(
     * section="Species",
     * resource=true,
     * description="Show a species from database.",
     * requirements={
     *     {
     *         "name": "id",
     *         "dataType": "integer",
     *         "requirements": "^\d+$"
     *     }
     * },
     * parameters={
     * },
     * statusCodes={
     *     200="Success.",
     *     404="Not found."
     * }
     * )
     */
    public function showAction(Request $request, Species $species)
    {
        return $this->handleView($this->view($species));
    }

    /**
     * @Rest\Put("/{id}")
     *
     * @ApiDoc(
     * section="Species",
     * resource=true,
     * description="Edit a species into database.",
     * input={"class": "AppBundle\Form\SpeciesType", "name": ""},
     * requirements={
     *     {
     *         "name": "id",
     *         "dataType": "integer",
     *         "requirements": "^\d+$"
     *     }
     * },
     * parameters={
     *     {
     *         "name"="name",
     *         "dataType"="string",
     *         "description"="The name of the species to add."
     *     }
     * },
     * statusCodes={
     *     200="Success.",
     *     400="Error, see form errors for details."
     * }
     * )
     */
    public function editAction(Request $request, Species $species)
    {
        $view = null;
        $form = $this->createForm(SpeciesType::class, $species);

        $form->submit($request->request->all());

        if ($species->getName() == '') {
            $form->addError(new FormError('Name cannot be empty'));
        }

        if ($form->isValid()) {
            $manager = $this->getDoctrine()->getManager();

            $manager->flush();

            $view = $this->view($species);
        } else {
            $view = $this->view($form);
        }

        return $this->handleView($view);
    }

    /**
     * @Rest\Delete("/{id}")
     *
     * @ApiDoc(
     * section="Species",
     * resource=true,
     * description="Deletes a species from database.",
     * requirements={
     *     {
     *         "name": "id",
     *         "dataType": "integer",
     *         "requirements": "^\d+$"
     *     }
     * },
     * parameters={
     * },
     * statusCodes={
     *     204="Success.",
     *     500="Internal crash."
     * }
     * )
     */
    public function deleteAction(Species $species)
    {
        $manager = $this->getDoctrine()->getManager();

        $manager->remove($species);

        $manager->flush();

        return $this->handleView($this->view(null, Response::HTTP_NO_CONTENT));
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