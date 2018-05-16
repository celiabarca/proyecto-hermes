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

    /**
     * 
     * @param Request $request
     * @param AuthenticationUtils $authenticationUtils
     * @return resultado de el login del usuario
     */
    public function login(Request $request, AuthenticationUtils $authenticationUtils) {
        $error = $authenticationUtils->getLastAuthenticationError();
        $nombreUsuarioAnterior = $authenticationUtils->getLastUsername();

        return $this->render('sesion/index.html.twig', [
            'error' => $error,
            'lastemail' => $nombreUsuarioAnterior
        ]);
    }
/**
 * 
 * @param Request $request
 * @param UserPasswordEncoderInterface $passwordEncoder
 * @return redireccion a la home si se realiza el registro correctamente o renderiza la
 * pagina de registro si no se ha enviado el formulario aun
 */
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

        return $this->render('usuario/registrarse.html.twig', [
            'form' => $form->createView()
        ]);
    }
    /**
     * 
     * @param User $usuario
     * @return Muestra la página de perfil del usuario
     */
    public function perfilUsuario(User $usuario) {
        return $this->render('usuario/perfil.html.twig', [
           'usuario' => $usuario
        ]);
    }
    /**
     * 
     * @param Request $request
     * @param User $usuario
     * @return renderiza la pagina de perfil del usuario
     */
    public function editarUsuario(Request $request, User $usuario) {
        $form = $this->createForm(RegisterType::class, $usuario);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($usuario);
            $manager->flush();
        }

        return $this->render('usuario/editar.html.twig', [
            'form' => $form->createView()
        ]);
    }
    
    /**
     * 
     * @return array de usuario la aportation total que han hecho a los proyectos
     */
    public function getTopUsers()
    {
        $users = $this->getDoctrine()->getRepository(User::class)->TopDonationUsers();

        return $users;
    }

}