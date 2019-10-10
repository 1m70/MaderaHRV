<?php

namespace App\Controller\Index;

use App\Controller\Helper;
use App\Controller\Swiftmailer\CustomMailer;
use App\Entity\Contact;
use App\Entity\Module;
use App\Entity\Oeuvre;
use App\Entity\OeuvreSearch;
use App\Entity\Plan;
use App\Form\ContactType;
use App\Form\OeuvreSearchType;
use App\Repository\ModuleRepository;
use App\Repository\OeuvreRepository;
use App\Repository\PlanRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class IndexController
 * @package App\Controller\Index
 * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
 */
class IndexController extends AbstractController
{

	use Helper;

    /**
     * @var ObjectManager
     */
	private $em;

	public function __construct(ObjectManager $em)
    {
        $this->em = $em;
    }

    /**
     * Accueil
     * @param Request $request
     * @param CustomMailer $mailer
     * @return Response
     */
	public function index(Request $request, CustomMailer $mailer)
    {
        # Récupération des 4 dernieres oeuvres
		$oeuvres = [];

        # Traitement du formulaire de contact
        $contact = new Contact();
		$contactForm = $this->createForm(ContactType::class, $contact);
		$contactForm->handleRequest($request);

		if ($contactForm->isSubmitted() && $contactForm->isValid()) {
		    $this->addFlash('success', 'Votre message à bien été envoyé');
		    $mailer->sendNotification(
		        'Madera: Message de '.$contact->getNom().' '. $contact->getPrenom(),
                $contact->getMail(),
                'ecloz',
                $contact->getMail(),
                'contact',
                ['contact' => $contact]
            );
        }

		return $this->render('index/index.html.twig',[
			'oeuvres'     => $oeuvres,
            'form' => $contactForm->createView()

		]);
	}

    /**
     * @Route("/planAjax", name="plan_editPlanAjax", methods={"POST"})
     * @param PlanRepository $repoPlan
     * @return JsonResponse
     */
    public function planBlueprintAjax(PlanRepository $repoPlan)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $dataTmp = $_POST['dataParam'];
        $idTmp = $_POST['dataId'];
        $aWallResult = $_POST['aResultWall'];

        $plan = $repoPlan->find(intval($idTmp));
        $bp = $plan->setBlueprint($dataTmp);

        $i = 1;
        foreach ($aWallResult as $wall){
            $module = new Module();

            $module->setName("Mur_" . $i);
            $module->setLength(number_format($wall, 2));
            $plan->addModule($module);
            $entityManager->persist($module);

            $i++;
        }

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($bp);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();


        return new JsonResponse(
            [
                'status' => true
            ]
        );
    }
}