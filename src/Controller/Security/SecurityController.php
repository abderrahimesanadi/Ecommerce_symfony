<?php

namespace App\Controller\Security;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\EventDispatcher\EventDispatcherInterface,
    Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken,
    Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class SecurityController extends AbstractController
{
    use TargetPathTrait;
    /**
     * @Route("/admin/inscription", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $userPasswordEncoder): Response
    {

        $user = new User();
        $req_uri = $request->server->get('REQUEST_URI');
        if ($req_uri == "\/admin/inscription") {
            $user->setRoles(["ROLE_ADMIN"]);
        }else{
            $user->setRoles(["ROLE_USER"]);
        }
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
           // return $this->redirectToRoute('admin_categories');
        }
        
        return $this->render('security/register_admin.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/connection", name="app_login")
     */
    public function index(Request $request,AuthenticationUtils $authenticationUtils): Response
    {
        $this->saveTargetPath($request->getSession(), 'main', $this->generateUrl('admin_category'));

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login_admin.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }

    /**
     * @Route("/inscription", name="app_register_custmer")
     */
    public function registerCustmer(Request $request,SessionInterface $session, EventDispatcherInterface $eventDispatcher,UserPasswordEncoderInterface $userPasswordEncoder, Security $security): Response
    {

        $user = new User();
        $user->setRoles(["ROLE_USER"]);
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email
           // $route = $request->headers->get('referer');
           
            /*$token = new UsernamePasswordToken($user, $user->getPassword(), "public", $user->getRoles());

            // For older versions of Symfony, use security.context here
            $this->get("security.token_storage")->setToken($token);
    
            // Fire the login event
            // Logging the user in above the way we do it doesn't do this automatically
            $event = new InteractiveLoginEvent($request, $token);
            $eventDispatcher->dispatch($event,"security.interactive_login");
            if($session->has("order")){
                $session->remove("order");
                return $this->redirectToRoute("app_order");
            }*/

            //return $this->redirectToRoute("products_index");
        }

        return $this->render('security/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/connection", name="app_login_custmer")
     */
    public function indexCustmer(Request $request, Security $security,AuthenticationUtils $authenticationUtils): Response
    {
        $this->saveTargetPath($request->getSession(), 'main', $this->generateUrl('products_index'));

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }
}
