<?php
/**
 * Created by PhpStorm.
 * User: magonxesp
 * Date: 8/05/18
 * Time: 17:38
 */

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller {

    public function login(Request $request, AuthenticationUtils $authenticationUtils) {
        $error = $authenticationUtils->getLastAuthenticationError();
        $nombreUsuarioAnterior = $authenticationUtils->getLastUsername();

        return $this->render('sesion/index.html.twig', [
            'error' => $error,
            'lastemail' => $nombreUsuarioAnterior
        ]);
    }

    public function registrarUsuario(Request $request, UserPasswordEncoderInterface $passwordEncoder) {
        $usuario = new User();
        $form = $this->createForm(RegisterType::class, $usuario);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $password = $passwordEncoder->encodePassword($usuario, $usuario->getPassword());
            $usuario->setPassword($password);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($usuario);
            $manager->flush();

            return $this->redirectToRoute('index');
        }

    }

}