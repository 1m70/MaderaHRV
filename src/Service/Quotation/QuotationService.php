<?php
/**
 * Created by PhpStorm.
 * User: hocin
 * Date: 09/10/2019
 * Time: 15:30
 */

namespace App\Service\Quotation;


use App\Entity\Module;
use App\Entity\Plan;
use App\Entity\Quotation;
use Doctrine\Common\Persistence\ObjectManager;
use PhpParser\Node\Stmt\Foreach_;

class QuotationService
{
    /**
     * @var Plan
     */
    private $plan;

    /**
     * @var int
     */
    private $priceHt = 0;

    /**
     * @var int
     */
    private $tva = 1.20;

    /**
     * @var ObjectManager
     */
    private $manager;

    private static $squareMeters = [
        "Plancher sur dalle",
        "Plancher porteur" ,
        "Couverture"
    ];

    /**
     * QuotationService constructor.
     * @param Plan $plan
     * @param ObjectManager $manager
     */
    public function __construct(Plan $plan,ObjectManager $manager)
    {
        $this->plan = $plan;
        $this->manager = $manager;
    }

    public function calculateQuotation() {

        Foreach ($this->plan->getModules() as $module){
            $modulePrice = $this->calculateModulePrice($module);
            $this->priceHt += $modulePrice;
        }

        $quotation = $this->plan->getQuotation()? $this->plan->getQuotation() : new Quotation();
        $date = new \DateTime();
        $dateString = $date->format('Y-m-d H:i:s');
        $quotation->setPrixHT($this->priceHt)
                  ->setPrixTTC($this->priceHt*$this->tva)
                  ->setLabel("Devis ".$dateString);
        $this->plan->setQuotation($quotation);
        $this->manager->persist($quotation);
        $this->manager->flush();

    }

    private function calculateModulePrice(Module $module) {
        $length = $module->getLength();
        if (in_array($module->getType()->getLabel(), $this::$squareMeters)){
            $length = $length* $module->getWidth();
        }
        $finitionPrice   = $module->getFinition() ? $length * $module->getFinition()->getPrice(): 0;
        $coveragePrice   = $module->getCoverage() ? $length * $module->getCoverage()->getPrice(): 0;
        $floorPrice      = ($module->getFloor())   ? $length * $module->getFloor()->getPrice() : 0;
        $isolationPrice  = $module->getIsolation()? $length * $module->getIsolation()->getPrice(): 0;
        $structurePrice  = $module->getStructure()? $length * $module->getStructure()->getPrice(): 0;
        $modulePrice     = $finitionPrice + $coveragePrice + $floorPrice + $isolationPrice + $structurePrice;
        $module->setPrice($modulePrice);
        $this->manager->flush();
        return $modulePrice;
    }


}