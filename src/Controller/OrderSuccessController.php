<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Classe\Mail;
use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderSuccessController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/commande/merci/{stripeSessionId}', name: 'order_validate')]
    public function index(Cart $cart, $stripeSessionId): Response
    {
        $order = $this->entityManager->getRepository(Order::class)->findOneBy(['stripeSessionId' => $stripeSessionId]);

        if (!$order || $order->getUser() != $this->getUser()) {
            return $this->redirectToRoute('home');
        }

        if ($order->getState() == 0) {
            //Vider la sesson "cart"
            $cart->remove();
            //Modifier statut isPaid de la commande en mettant 1
            $order->setState(1);
            $this->entityManager->flush();
            //Envoyer un email au client pour confirmer sa commande
            $mail = new Mail();
            $contentMail = "Bonjour " . $order->getUser()->getFirstname() . "<br/> Votre commande du site est validée";
            $mail->send($order->getUser()->getEmail(), $order->getUser()->getFirstname(), 'Votre commande du site est validée', $contentMail);
        }

        return $this->render('order_success/index.html.twig', [
            'order' => $order
        ]);
    }
}
