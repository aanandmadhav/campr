<?php

namespace AppBundle\Controller\API;

use AppBundle\Entity\RiskStrategy;
use AppBundle\Form\RiskStrategy\CreateType;
use MainBundle\Controller\API\ApiController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/api/risk-strategy")
 */
class RiskStrategyController extends ApiController
{
    /**
     * Get all risk strategies.
     *
     * @Route("/list", name="app_api_risk_strategy_list")
     * @Method({"GET"})
     *
     * @return JsonResponse
     */
    public function listAction()
    {
        $riskStrategies = $this
            ->getDoctrine()
            ->getRepository(RiskStrategy::class)
            ->findAll()
        ;

        return $this->createApiResponse($riskStrategies);
    }

    /**
     * Create a new Risk Strategy.
     *
     * @Route("/create", name="app_api_risk_strategy_create")
     * @Method({"POST"})
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function createAction(Request $request)
    {
        $data = $request->request->all();
        $form = $this->createForm(CreateType::class, null, ['csrf_protection' => false]);
        $form->submit($data);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($form->getData());
            $em->flush();

            return $this->createApiResponse($form->getData(), JsonResponse::HTTP_CREATED);
        }

        $errors = [];
        foreach ($form->getErrors(true) as $error) {
            $errors[] = $error->getMessage();
        }

        return $this->createApiResponse($errors);
    }

    /**
     * Get Risk Strategy by id.
     *
     * @Route("/{id}", name="app_api_risk_strategy_get")
     * @Method({"GET"})
     *
     * @param RiskStrategy $riskStrategy
     *
     * @return JsonResponse
     */
    public function getAction(RiskStrategy $riskStrategy)
    {
        return $this->createApiResponse($riskStrategy);
    }

    /**
     * Edit a specific Risk Strategy.
     *
     * @Route("/{id}/edit", name="app_api_risk_strategy_edit")
     * @Method({"POST"})
     *
     * @param Request      $request
     * @param RiskStrategy $riskStrategy
     *
     * @return JsonResponse
     */
    public function editAction(Request $request, RiskStrategy $riskStrategy)
    {
        $data = $request->request->all();
        $form = $this->createForm(CreateType::class, $riskStrategy, ['csrf_protection' => false]);
        $form->submit($data, false);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($riskStrategy);
            $em->flush();

            return $this->createApiResponse($riskStrategy);
        }

        $errors = [];
        foreach ($form->getErrors(true) as $error) {
            $errors[] = $error->getMessage();
        }

        return $this->createApiResponse($errors);
    }

    /**
     * Delete a specific Risk Strategy.
     *
     * @Route("/{id}/delete", name="app_api_risk_strategy_delete")
     * @Method({"DELETE"})
     *
     * @param RiskStrategy $riskStrategy
     *
     * @return JsonResponse
     */
    public function deleteAction(RiskStrategy $riskStrategy)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($riskStrategy);
        $em->flush();

        return $this->createApiResponse([], JsonResponse::HTTP_NO_CONTENT);
    }
}