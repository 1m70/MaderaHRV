<?php

namespace App\Controller\Index;

use App\Entity\Module;
use App\Entity\Plan;
use App\Entity\Quotation;
use App\Form\Plan1Type;
use App\Repository\PlanRepository;
use App\Service\Quotation\QuotationService;
use Doctrine\Common\Persistence\ObjectManager;
use Dompdf\Dompdf;
use Dompdf\Options;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/plan")
 * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
 */
class PlanController extends AbstractController
{
    /**
     * @Route("/", name="plan_index", methods={"GET"})
     */
    public function index(PlanRepository $planRepository): Response
    {
        return $this->render('plan/index.html.twig', [
            'plans' => $planRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="plan_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $plan = new Plan();
        $form = $this->createForm(Plan1Type::class, $plan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($plan);
            $entityManager->flush();

            return $this->redirectToRoute('plan_index');
        }

        return $this->render('plan/new.html.twig', [
            'plan' => $plan,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="plan_show", methods={"GET"})
     */
    public function show(Plan $plan): Response
    {
        return $this->render('plan/show.html.twig', [
            'plan' => $plan,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="plan_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Plan $plan
     * @param ObjectManager $manager
     * @return Response
     */
    public function edit(Request $request, Plan $plan, ObjectManager $manager): Response
    {
        $form = $this->createForm(Plan1Type::class, $plan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Module $module */
            Foreach($form->getData()->getModules() as $module){
                $module->setPlan($plan);
                $manager->persist($plan);
            }
            $manager->flush();
            $quotationService = new QuotationService($plan, $manager);
            $quotationService->calculateQuotation();
            return $this->redirectToRoute('plan_show', ['id' => $plan->getId()]);
        }

        return $this->render('plan/edit.html.twig', [
            'plan' => $plan,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/plan", name="plan_editPlan", methods={"GET","POST"})
     * @param Request $request
     * @param Plan $plan
     * @param ObjectManager $manager
     * @return Response
     */
    public function editPlan(Request $request, Plan $plan, ObjectManager $manager): Response
    {
        $form = $this->createForm(Plan1Type::class, $plan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Module $module */
            Foreach($form->getData()->getModules() as $module){
                $module->setPlan($plan);
                $manager->persist($plan);
            }
            $manager->flush();
            $quotationService = new QuotationService($plan, $manager);
            $quotationService->calculateQuotation();
            return $this->redirectToRoute('plan_show', ['id' => $plan->getId()]);
        }

        return $this->render('plan/plan.html.twig', [
            'plan' => $plan
        ]);
    }


    /**
     * @Route("/{id}", name="plan_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Plan $plan): Response
    {
        if ($this->isCsrfTokenValid('delete'.$plan->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($plan);
            $entityManager->flush();
        }

        return $this->redirectToRoute('plan_index');
    }

    /**
     * @Route("/quotation/{id}", name="admin_quotation", methods={"GET"})
     *
     * @return void
     */
    public function quotation(Plan $plan)
    {
        if ( $this->getUser() != $plan->getProject()->getUser() ){
            throw $this->createNotFoundException();
        }

        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($pdfOptions);

        $html = $this->renderView('components/quotation.html.twig', [
            'plan'  => $plan,
            'date'=>new \DateTime()
        ]);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream("contrat.pdf", [
            "Attachment" => false
        ]);
    }
}
