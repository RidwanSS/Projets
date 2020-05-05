<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Users;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\UserRepository;

use Symfony\Contracts\Translation\TranslatorInterface;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**
     * @Route("/editRole/{id}", name="editRole")
     */
    public function editRole(User $user = null, TranslatorInterface $translator){
        if($user == null){
            return $this->redirectToRoute('produit');
            $this->addFlash("danger", $translator->trans('flash.impossiblerole'));
        }
        
        if( in_array('ROLE_ADMIN', $user->getRoles() )){ //Pour changer de user a admmin et de admin a user
            $user->setRoles( ['ROLE_USER'] );
            $this->addFlash("success", $translator->trans('flash.edituser'));
        }else{
            $user->setRoles( ['ROLE_USER', 'ROLE_ADMIN'] );
            $this->addFlash("success", $translator->trans('flash.editadmin'));
        }
        // $user->setRoles( ['ROLE_USER',  'ROLE_ADMIN']);
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        return $this->redirectToRoute('users');

    }

    /**
     * @Route("/editroleadmin/{id}", name="editroleadmin")
     */
    public function editRoleAdmin(User $user = null, TranslatorInterface $translator){
        if($user == null){
            return $this->redirectToRoute('produit');
            $this->addFlash("danger", $translator->trans('flash.impossiblerole'));
        }
        
        if( in_array('ROLE_SUPER_ADMIN', $user->getRoles() )){ //Pour changer de super_admin a admmin et de admin a super_admin
            $user->setRoles( ['ROLE_USER','ROLE_ADMIN'] );
            $this->addFlash("success", $translator->trans('flash.editadmin'));
        }else{
            $user->setRoles( ['ROLE_USER','ROLE_ADMIN', 'ROLE_SUPER_ADMIN'] );
            $this->addFlash("success", $translator->trans('flash.editsuperadmin'));
        }
        
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        return $this->redirectToRoute('users');

    }

    /**
     * @Route("/admin/users", name="users")
     */
    public function users(){
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository(User::class)->findAll();

        return $this->render('admin/user.html.twig',[
            'users' => $users
        ]);

    }
}
