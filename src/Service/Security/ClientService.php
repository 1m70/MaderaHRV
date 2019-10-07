<?php
/**
 * Created by PhpStorm.
 * User: hocine
 * Date: 26/12/18
 * Time: 12:22
 */

namespace App\Service\Security;


use App\Entity\Client;
use App\Repository\ClientRepository;
use Symfony\Component\HttpFoundation\Request;

class ClientService
{
    /**
     * @var ClientRepository
     */
    private $clientRepository;

    /**
     * ClientService constructor.
     * @param ClientRepository $clientRepository
     */
    public function __construct(ClientRepository $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    /**
     * @param $mail
     * @param Request $request
     * @param $error
     * @return null|string
     */
    public function checkLoginErrors($mail, Request $request, $error)
    {
        $message = $isActivated = null;
        /** @var Client $user */
        $user = $this->clientRepository->findClientByMail($mail);
        if ($user && $request->isMethod('POST')){
            $isActivated  = $user[0]->getIsActive(); // True if isActivated
        }
        if ($isActivated === false){
            $message = 'Votre compte n\'a pas encore été activé';
        } elseif ((!empty($error)) ) {
            $message = 'Votre mot de passe ou votre mail est invalide';
        }
        return $message;
    }

}