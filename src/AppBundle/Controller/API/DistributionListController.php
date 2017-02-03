<?php

namespace AppBundle\Controller\API;

use AppBundle\Entity\DistributionList;
use AppBundle\Form\DistributionList\CreateType;
use AppBundle\Security\DistributionListVoter;
use MainBundle\Controller\API\ApiController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/api/distribution-lists")
 */
class DistributionListController extends ApiController
{
    /**
     * Get DistributionList by id.
     *
     * @Route("/{id}", name="app_api_distribution_list_get")
     * @Method({"GET"})
     *
     * @param DistributionList $distributionList
     *
     * @return JsonResponse
     */
    public function getAction(DistributionList $distributionList)
    {
        $this->denyAccessUnlessGranted(DistributionListVoter::VIEW, $distributionList);

        return $this->createApiResponse($distributionList);
    }

    /**
     * Edit a specific DistributionList.
     *
     * @Route("/{id}", name="app_api_distribution_list_edit")
     * @Method({"PUT", "PATCH"})
     *
     * @param Request          $request
     * @param DistributionList $distributionList
     *
     * @return JsonResponse
     */
    public function editAction(Request $request, DistributionList $distributionList)
    {
        $this->denyAccessUnlessGranted(DistributionListVoter::EDIT, $distributionList);

        $form = $this->createForm(CreateType::class, $distributionList, ['csrf_protection' => false]);
        $this->processForm($request, $form, $request->isMethod(Request::METHOD_PUT));

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($distributionList);
            $em->flush();

            return $this->createApiResponse($distributionList, Response::HTTP_ACCEPTED);
        }

        $errors = $this->getFormErrors($form);
        $errors = [
            'messages' => $errors,
        ];

        return $this->createApiResponse($errors, Response::HTTP_BAD_REQUEST);
    }

    /**
     * Delete a specific DistributionList.
     *
     * @Route("/{id}", name="app_api_distribution_list_delete")
     * @Method({"DELETE"})
     *
     * @param DistributionList $distributionList
     *
     * @return JsonResponse
     */
    public function deleteAction(DistributionList $distributionList)
    {
        $this->denyAccessUnlessGranted(DistributionListVoter::DELETE, $distributionList);

        $em = $this->getDoctrine()->getManager();
        $em->remove($distributionList);
        $em->flush();

        return $this->createApiResponse(null, Response::HTTP_NO_CONTENT);
    }
}
