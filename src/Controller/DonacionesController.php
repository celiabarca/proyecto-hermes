<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Project;
use Symfony\Component\HttpFoundation\Request;

class DonacionesController extends Controller
{
    /**
     * Por implementar
     * @return mixed
     */
    public function Donar(Project $proyecto, Request $req)
  {
    if ($request->isMethod('POST')) 
        {
        $form->handleRequest($request);
        if ($form->isValid()) 
        {
            $data = $form->getData();
            $precio = $form["precio"];
            $this->get('App\Client\Stripe')->CrearCargo($this->getUser(), $form->get('token')->getData(),$data['precio']);
            $redirect = $this->get('session')->get('premium_redirect');
            $redirect = $this->generateUrl('premium_payment');
            return $this->redirectToRoute("proyecto",["id"=>$proyecto->getId()]);
        }
    }
      
      return $this->redirectToRoute("proyecto",["id"=>$proyecto->getId()]);
  }
}
