<?php

namespace App\Controller;

use App\Entity\Merchant;
use App\Form\MerchantType;
use App\Repository\MerchantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/merchant")
 */
class MerchantController extends AbstractController
{
    /**
     * @Route("/", name="merchant_index", methods={"GET"})
     */
    public function index(MerchantRepository $merchantRepository): Response
    {
        return $this->render('merchant/index.html.twig', ['merchants' => $merchantRepository->findAll()]);
    }

    /**
     * @Route("/new", name="merchant_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $merchant = new Merchant();
        $form = $this->createForm(MerchantType::class, $merchant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($merchant);
            $entityManager->flush();

            return $this->redirectToRoute('merchant_index');
        }

        return $this->render('merchant/new.html.twig', [
            'merchant' => $merchant,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="merchant_show", methods={"GET"})
     */
    public function show(Merchant $merchant): Response
    {
        return $this->render('merchant/show.html.twig', ['merchant' => $merchant]);
    }

    /**
     * @Route("/{id}/edit", name="merchant_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Merchant $merchant): Response
    {
        $form = $this->createForm(MerchantType::class, $merchant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('merchant_index', ['id' => $merchant->getId()]);
        }

        return $this->render('merchant/edit.html.twig', [
            'merchant' => $merchant,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="merchant_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Merchant $merchant): Response
    {
        if ($this->isCsrfTokenValid('delete'.$merchant->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($merchant);
            $entityManager->flush();
        }

        return $this->redirectToRoute('merchant_index');
    }
}
