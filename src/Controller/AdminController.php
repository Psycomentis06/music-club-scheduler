<?php

namespace App\Controller;

use App\Entity\Activity;
use App\Entity\Coach;
use App\Entity\Seance;
use App\Entity\User;
use App\Form\ActivityFormType;
use App\Form\CoachType;
use App\Form\SeanceType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class AdminController extends AbstractController {
    /**
     * @Route("/admin/", name="admin_home")
     */
    public function adminHome() {
        
        $this->denyAccessUnlessGranted('ROLE_ADMIN'); // don't let user pass only if he is an admin

        // get users

        $users = $this->getDoctrine()->getRepository(User::class)
        ->findAll();

        return $this->render('admin/home.html.twig', ['users' => $users]);
    }

    /**
     * @Route("/admin/user/{id}", name="admin_view_user")
     */
    public function viewUser ($id) {
        $this->denyAccessUnlessGranted('ROLE_ADMIN'); // don't let user pass only if he is an admin

        $user = $this->getDoctrine()->getRepository(User::class)
        ->find($id);

        return $this->render('admin/user.html.twig', ['data' => $user]);
    }

    /**
     * @Route("/admin/user/remove/{id}", name="admin_remove_user")
     */
    public function removeUser($id) {
        $this->denyAccessUnlessGranted('ROLE_ADMIN'); // don't let user pass only if he is an admin

        $user = $this->getDoctrine()->getRepository(User::class)
        ->find($id);

        $userName = $user->getFirstName().' '.$user->getLastName();

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($user);
        $entityManager->flush();
        
        $seesion = new Session();
        $seesion->getFlashBag()
        ->add('notice', 'The user'. $userName .' Deleted Successfully');

        return $this->redirectToRoute('admin_home');
    }


    /**
     * @Route("/admin/activity", name="admin_activity")
     */
    public function adminActivties (Request $request) {
        $this->denyAccessUnlessGranted('ROLE_ADMIN'); // don't let user pass only if he is an admin

        $act = new Activity();
        $randomID = rand(1, 99999999);
        $act->setCodeAct($randomID);

        // create form
        $form = $this->createForm(ActivityFormType::class, $act);
        $form->handleRequest($request);
        //validate form
        if ($form->isSubmitted() && $form->isValid()) {
            // add activity
            $newAct = $this->getDoctrine()->getManager();
            $newAct->persist($act);
            $newAct->flush();

            // successful Activity created
            $session = new Session();
            $session->getFlashBag()
            ->add('notice', 'The new Activity has been created successfully');
        }

        // get Activities
        $activities = $this->getDoctrine()->getRepository(Activity::class)
        ->findAll();
        return $this->render('admin/activity.html.twig', ['form_add' => $form->createView(), 'activities' => $activities]);
    }
    /**
     * @Route("/admin/activity/remove/{id}", name="admin_remove_act")
     */
    public function removeActivity ($id) {
        $this->denyAccessUnlessGranted('ROLE_ADMIN'); // don't let user pass only if he is an admin

        $act = $this->getDoctrine()->getRepository(Activity::class)
        ->find($id);

        $actLib = $act->getLibAct();

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($act);
        $entityManager->flush();
        
        $seesion = new Session();
        $seesion->getFlashBag()
        ->add('notice', 'Activity "'. $actLib .'" Deleted Successfully');

        return $this->redirectToRoute('admin_activity');
    }

    /**
     * @Route("/admin/coaches", name="admin_coach")
     */
    public function adminCoches (Request $request) {
        $this->denyAccessUnlessGranted('ROLE_ADMIN'); // don't let user pass only if he is an admin

        $coach = new Coach();
        $randomID = rand(1, 99999999); //random code
        $coach->setCodeCo($randomID);

        $form = $this->createForm(CoachType::class, $coach);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // add coach
            $newCoach = $this->getDoctrine()->getManager();
            $newCoach->persist($coach);
            $newCoach->flush();

            // successful Coach created
            $session = new Session();
            $session->getFlashBag()
            ->add('notice', 'New Coach has been created successfully');
        }

        // get Coaches
        $coaches = $this->getDoctrine()->getRepository(Coach::class)
        ->findAll();
        return $this->render('admin/coach.html.twig',['form' => $form->createView(), 'coaches' => $coaches]);
    }

    /**
     * @Route("/admin/coach/remove/{id}", name="admin_remove_co")
     */
    public function removeCoach ($id) {
        $this->denyAccessUnlessGranted('ROLE_ADMIN'); // don't let user pass only if he is an admin

        $coach = $this->getDoctrine()->getRepository(Coach::class)
        ->find($id);

        $coName = $coach->getFirstName().' '.$coach->getLastName();

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($coach);
        $entityManager->flush();
        
        $seesion = new Session();
        $seesion->getFlashBag()
        ->add('notice', 'Coach "'. $coName .'" Deleted Successfully');

        return $this->redirectToRoute('admin_coach');
    }

    /**
     * @Route("/admin/coach/edit/{id}", name="admin_co_edit")
     */

     public function editCoach (Request $request, $id) {
        $this->denyAccessUnlessGranted('ROLE_ADMIN'); // don't let user pass only if he is an admin

        $em = $this->getDoctrine()->getManager();

        $coach = $em->getRepository(Coach::class)->find($id);


        $form = $this->createForm(CoachType::class, $coach);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->flush();

            $session = new Session();
            $session->getFlashBag()
            ->add('notice', 'Coach Edited Successfully');

            return $this->redirectToRoute('admin_coach');
        }

        return $this->render('admin/coach_edit.html.twig', [
            'form' => $form->createView(),
            'coach' => $coach
        ]);
     }

    /**
     * @Route("/admin/sessions", name="admin_sessions")
     */
    public function adminSession () {
        $this->denyAccessUnlessGranted('ROLE_ADMIN'); // don't let user pass only if he is an admin

        $seance = $this->getDoctrine()->getRepository(Seance::class)
        ->findAll();

        return $this->render('admin/session.html.twig', ['sessions' => $seance]);
    }

    /**
     * @Route("/admin/sessions/add", name="admin_new_sessions")
     */
    public function adminNewSession (Request $request) {
        $this->denyAccessUnlessGranted('ROLE_ADMIN'); // don't let user pass only if he is an admin

        $seance = new Seance();

        $form = $this->createForm(SeanceType::class, $seance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newSeance = $this->getDoctrine()->getManager();

            $newSeance->persist($seance);

            $newSeance->flush();

            $seesion = new Session();
            $seesion->getFlashBag()
            ->add('notice', 'Session created Successfully');
    
            return $this->redirectToRoute('admin_sessions');
        }

        return $this->render('admin/session_new.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/admin/session/remove/{id}", name="admin_remove_session")
     */
    public function removeSession ($id) {
        $this->denyAccessUnlessGranted('ROLE_ADMIN'); // don't let user pass only if he is an admin

        $session = $this->getDoctrine()->getRepository(Seance::class)
        ->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($session);
        $entityManager->flush();
        
        $seesion = new Session();
        $seesion->getFlashBag()
        ->add('notice', 'Session Deleted Successfully');

        return $this->redirectToRoute('admin_sessions');
    }

    /**
     * @Route("/admin/session/edit/{id}", name="admin_session_edit")
     */

    public function editSession (Request $request, $id) {
        $this->denyAccessUnlessGranted('ROLE_ADMIN'); // don't let user pass only if he is an admin

        $em = $this->getDoctrine()->getManager();

        $seance = $em->getRepository(Seance::class)->find($id);


        $form = $this->createForm(SeanceType::class, $seance);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->flush();

            $session = new Session();
            $session->getFlashBag()
            ->add('notice', 'Session Edited Successfully');

            return $this->redirectToRoute('admin_sessions');
        }

        return $this->render('admin/session_edit.html.twig', [
            'form' => $form->createView(),
            'seance' => $seance
        ]);
     }

}

?>