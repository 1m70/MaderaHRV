<?php
/**
 * Created by PhpStorm.
 * User: hocin
 * Date: 07/10/2019
 * Time: 17:36
 */

namespace App\Controller\Admin;


use App\Controller\Helper;
use App\Repository\CustomerRepository;
use App\Repository\ProjectRepository;
use App\Repository\UserRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{

    use Helper;

    /**
     * @var ObjectManager
     */
    private $manager;
    /**
     * @var ProjectRepository
     */
    private $projectRepository;
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var CustomerRepository
     */
    private $customerRepository;

    /**
     * AdminController constructor.
     * @param ObjectManager $manager
     * @param ProjectRepository $projectRepository
     * @param UserRepository $userRepository
     * @param CustomerRepository $customerRepository
     */
    public function __construct(ObjectManager $manager,
                                ProjectRepository $projectRepository,
                                UserRepository $userRepository,
                                CustomerRepository $customerRepository)
    {
        $this->manager = $manager;
        $this->projectRepository = $projectRepository;
        $this->userRepository = $userRepository;
        $this->customerRepository = $customerRepository;
    }

    /**
     * @Route("/admin", name="admin_index", methods={"GET"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function admin() {

        $data["nbSalers"] = count($this->userRepository->findAll());
        $data["nbCustomers"] = count($this->customerRepository->findAll());
        $data["nbProjects"] = count($this->userRepository->findAll());
        return $this->render('admin/index.html.twig',[
            'data'        => $data,
        ]);

    }
}