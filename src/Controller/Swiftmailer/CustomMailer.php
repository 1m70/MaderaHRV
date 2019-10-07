<?php
/**
 * Created by PhpStorm.
 * User: hocin
 * Date: 12/11/2018
 * Time: 08:38
 */

namespace App\Controller\Swiftmailer;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Twig\Environment;
use Twig_Error_Loader;

class CustomMailer
{
    private $mailer;
    private $eclozMail = 'ecloze@hotmail.fr';
    /**
     * @var Environment
     */
    private $renderer;

    public function __construct(\Swift_Mailer $mailer, Environment $renderer)
    {
        $this->mailer = $mailer;
        $this->renderer = $renderer;
    }

    /**
     * @param null $subject
     * @param null $from
     * @param null $to
     * @param null $replyTo
     * @param null $location
     * @param null $data
     */
    public function sendNotification ($subject = null, $from = null, $to = null, $replyTo = null, $location = null, $data = null)
    {
        $message = null;
        if ($from == 'ecloz')   $from = $this->eclozMail;
        if($to == 'ecloz')      $to = $this->eclozMail;
        if($replyTo == 'ecloz') $replyTo = $this->eclozMail;

        try {
            $message = (new \Swift_Message($subject))
                ->setFrom($from)
                ->setTo($to)
                ->setReplyTo($replyTo)
                ->setBody(
                    $this->renderer->render(
                        'mail/'.$location.'.html.twig', $data
                    )
                )
                ->setContentType("text/html");


        } catch (Twig_Error_Loader $e) {
            throw new NotFoundHttpException($e);
        } catch (\Twig_Error_Runtime $e) {
            throw new NotFoundHttpException($e);
        } catch (\Twig_Error_Syntax $e) {
            throw new NotFoundHttpException($e);
        }

        $this->mailer->send($message);


    }
}