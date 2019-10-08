<?php

namespace App\Controller\Index;

use App\Controller\Helper;
use App\Controller\Swiftmailer\CustomMailer;
use App\Entity\Contact;
use App\Entity\Oeuvre;
use App\Entity\OeuvreSearch;
use App\Form\ContactType;
use App\Form\OeuvreSearchType;
use App\Repository\OeuvreRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
}