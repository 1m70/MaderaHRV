<?php
/**
 * Created by PhpStorm.
 * User: hocin
 * Date: 16/11/2018
 * Time: 19:03
 */

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Contact
{

    /**
     * @var string|null
     * @Assert\Length(
     *      min = 2,
     *     minMessage="Votre nom est trop court, au moins deux lettres"
     * )
     */
    private $nom;

    /**
     * @var string|null
     * @Assert\Length(
     *      min = 2,
     *     minMessage="Votre prenom est trop court, au moins deux lettres"
     * )
     */
    private $prenom;

    /**
     * @var string|null
     * @Assert\Email(
     *     message="Cette adresse mail n'est pas valide",
     *     checkMX= true
     * )
     */
    private $mail;

    /**
     * @var string|null
     * @Assert\Length(
     *     max="20"
     * )
     *  @Assert\Regex(
     *     pattern="^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\./0-9]*$^"
     * )
     *
     */
    private $telephone;

    /**
     * @var string|null
     * @Assert\Length(
     *     min="10"
     * )
     */
    private $message;

    /**
     * @return null|string
     */
    public function getNom(): ?string
    {
        return $this->nom;
    }

    /**
     * @param null|string $nom
     * @return Contact
     */
    public function setNom(string $nom): Contact
    {
        $this->nom = $nom;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    /**
     * @param null|string $prenom
     * @return Contact
     */
    public function setPrenom(string $prenom): Contact
    {
        $this->prenom = $prenom;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getMail(): ?string
    {
        return $this->mail;
    }

    /**
     * @param null|string $mail
     * @return Contact
     */
    public function setMail(string $mail): Contact
    {
        $this->mail = $mail;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    /**
     * @param null|string $telephone
     * @return Contact
     */
    public function setTelephone(string $telephone): Contact
    {
        $this->telephone = $telephone;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @param null|string $message
     * @return Contact
     */
    public function setMessage(string $message): Contact
    {
        $this->message = $message;
        return $this;
    }






}