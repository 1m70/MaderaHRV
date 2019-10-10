<?php

namespace App\Controller\Index;

use App\Controller\Helper;
use App\Controller\Swiftmailer\CustomMailer;
use App\Entity\Contact;
use App\Entity\Oeuvre;
use App\Entity\OeuvreSearch;
use App\Entity\Plan;
use App\Entity\Project;
use App\Form\ContactType;
use App\Form\OeuvreSearchType;
use App\Repository\OeuvreRepository;
use DateTime;
use Doctrine\Common\Persistence\ObjectManager;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
		        'NLOCArt: Message de '.$contact->getNom().' '. $contact->getPrenom(),
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
     * @Route("/plan", name="project_plan", methods={"GET"})
     */
    public function plan(): Response
    {
        return $this->render('project/plan.html.twig', [
            'project' => '',
        ]);
    }


    /**
     * @Route("/bps", name="project_blueprint", methods={"GET"})
     */
    public function setBlueprintAjax(Request $req){
        $blueprint = $_GET['dataParam'];

        $entityManager = $this->getDoctrine()->getManager();

        $planDB = new Plan();
        $dateOjd = new DateTime();
        $planDB->setDateCreation($dateOjd);
        $planDB->setBlueprint($blueprint);
        $planDB->setName("TestBlueprint");

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($planDB);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        dd($blueprint);

        $output = ['success' => true];
        return new JsonResponse($output);
    }

    /**
     * @Route("/bpg", name="project_blueprint", methods={"GET"})
     */
    public function getBlueprintAjax(Plan $plan){
        $blueprint = $_GET['dataParam'];
        $plan->getBlueprint();

        dd($blueprint);

        $output = ['success' => true];
        return new JsonResponse($output);
    }
}