<?php

namespace App\Controller;

use App\Entity\Flight;
use App\Form\FormFlightType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FlightController extends AbstractController
{
    
    #[Route('/flight', name: 'app_flight')]
    public function showForm(){
        $flight = new Flight();
        $form = $this->createForm(FormFlightType::class,$flight);
        return $this->render('Front/Flight/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/gestionflight', name: 'app_gflight')]
    public function showFlightAdmin(){
        return $this->render('Admin/flight/flight.html.twig');
    }


}
