<?php
/**
 * Created by PhpStorm.
 * User: magonxesp
 * Date: 8/05/18
 * Time: 17:38
 */

namespace App\Controller;

use App\Entity\User;
use App\Form\EditarUsuarioType;
use App\Form\RegisterType;
use App\Repository\UserRepository;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends Controller {

    private $userRepository;
    private $uploader;

    public function __construct(UserRepository $userRepository, FileUploader $uploader) {
        $this->userRepository = $userRepository;
        $this->uploader = $uploader;
    }

    /**
     * Inicia sesion con un usuario
     * @param Request $request
     * @param AuthenticationUtils $authenticationUtils
     * @return mixed
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
     * Cargar home
     *
     * @Route("/test/", name="test")
     * 
     */
    public function test(){
        return $this->render('error.html.twig');
    }

    /**
     * Registra un usuario
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return \Symfony\Component\HttpFoundation\Response
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
     * Renderiza el perfil de un usuario
     * @param User $usuario
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function perfilUsuario(User $usuario) {
        
        return $this->render('usuario/perfil.html.twig', [
           'usuario' => $usuario
        ]);
    }

    /**
     * Edita un usuario
     * @param Request $request
     * @param User $usuario
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editarUsuario(Request $request, User $usuario, UserPasswordEncoderInterface $passwordEncoder) {
        if($usuario !== $this->getUser()) {
            return $this->redirectToRoute('index');
        }

        $oldpassword = $usuario->getPassword();
        $oldimg = $usuario->getImg();
        $form = $this->createForm(EditarUsuarioType::class, $usuario);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            if($form->getData()->getPassword()) {
                $password = $passwordEncoder->encodePassword($usuario, $usuario->getPassword());
                $usuario->setPassword($password);
            } else {
                $usuario->setPassword($oldpassword);
            }

            if($usuario->getImg()) {
                $uploadedFilename = $this->uploader->upload($usuario->getImg());
                $path = $this->uploader->getUploadsDirectory().'/'.$uploadedFilename;
                $usuario->setImg($path);
            } else {
                $usuario->setImg($oldimg);
            }

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($usuario);
            $manager->flush();

            return $this->redirectToRoute('usuario_perfil', [
                'id' => $usuario->getId()
            ]);
        }

        return $this->render('usuario/editar.html.twig', [
            'form' => $form->createView(),
            'usuario' => $usuario
        ]);
    }
    
    /**
     * Devuelve array de usuario la aportation total que han hecho a los proyectos
     * @return array
     */
    public function getTopUsers()
    {
        $users = $this->userRepository->TopDonationUsers();
        return $users;
    }

}