<?php

namespace App\Service\Twig;


use App\Controller\Helper;
use App\Entity\Artiste;
use App\Entity\Oeuvre;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Extension\AbstractExtension;

class AppExtension extends AbstractExtension
{

	use Helper;

	/**
     * @var UrlGeneratorInterface
     */
	private $router;


	public function __construct(UrlGeneratorInterface $router)
	{
		$this->router = $router;
	}

	public function getFilters()
	{
		return [

//			new \Twig_Filter('slugify', function($text) {
//
//				return $this->slugify($text);
//
//			}), # -- Fin de Twig Filter Slugify
//
//            new \Twig_Filter('oeuvrelink', function(Oeuvre $oeuvre) {
//                return $this->router->generate('index_oeuvre', [
//                    'pseudoartiste'       => $this->slugify($oeuvre->getArtiste()->getPseudoArtiste()),
//                    'slugoeuvre'       => $this->slugify($oeuvre->getNomOeuvre()),
//                    'id'               => $oeuvre->getId()
//                ]);
//            }), # -- Fin de Twig Filter oeuvrelink
//
//            new \Twig_Filter('str_pad', function(int $id) {
//                return str_pad($id, 10, '0', STR_PAD_LEFT);
//            }), # -- Fin de Twig Filter strpas

		]; # -- Fin du Array

	}  # -- Fin de getFilters

}