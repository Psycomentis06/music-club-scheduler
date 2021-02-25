<?php
namespace App\Controller;

use App\Entity\Seance;
use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class ClubController extends AbstractController {
    private $passwordEncoder;
    public function __construct(UserPasswordEncoderInterface $passwordEncoder) {
        $this->passwordEncoder = $passwordEncoder;
    }
    /**
     * @Route("/", name="homepage")
     */
    public function home () {
        return $this->render('normal/home.html.twig');
    }

    /**
     *  @Route("/register", name="app_register")
     */
    public function register (Request $request) {
        // create form

        $user = new User();
        $user->setRoles(['ROLE_USER']);
        $form = $this->createForm(UserType::class, $user);
        
        // validating form

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            // insert user in database

            $newUser = $this->getDoctrine()->getManager();
            $user->setPassword($this->passwordEncoder->encodePassword($user, $data->getPassword()));
            $newUser->persist($user);
            $newUser->flush();

            // successful user created
            $session = new Session();
            $session->getFlashBag()
            ->add('notice', 'Your account has been created successfully');
            return $this->redirectToRoute('homepage');
        }

        return $this->render('normal/register.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/user/", name="user_profile")
     */
    public function getUserProfile() {
        $this->denyAccessUnlessGranted('ROLE_USER'); // don't let user pass only if he is an admin or user

        return $this->render('user/home.html.twig');

    }

    /**
     * @Route("/user/edit", name="user_edit")
     */
    public function editUser(Request $request) {
        $this->denyAccessUnlessGranted('ROLE_USER'); // don't let user pass only if he is an admin or user

        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $user->setPassword($this->passwordEncoder->encodePassword($user, $data->getPassword()));

            $em->flush();

            $session = new Session();
            $session->getFlashBag()
            ->add('notice', 'Your account Edited Successfully');

            return $this->redirectToRoute('user_profile');
        }

        return $this->render('user/edit.html.twig', ['form' => $form->createView()]);

    }

    /**
     * @Route("/user/list", name="users_list")
     */
    public function viewUsers() {
        $this->denyAccessUnlessGranted('ROLE_USER'); // don't let user pass only if he is an admin or user

        $users = $this->getDoctrine()->getRepository(User::class)
        ->findAll();

        return $this->render('user/users_list.html.twig', ['users' => $users]);

    }

    /**
     * @Route("/sessions", name="session_schedule")
     */
    public function sessionsSchedule() 
    {

        $sessions = $this->getDoctrine()->getRepository(Seance::class)
        ->findAll();

        return $this->render('user/sessions_date.html.twig', ['sessions' => $sessions]);

    }
}
?>