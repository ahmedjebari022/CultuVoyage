<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Form\FormRegisterType;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends AbstractController
{
    private $manager;
    private UserRepository $repo;

    public function __construct(ManagerRegistry $manager,UserRepository $repo){
        $this->manager=$manager->getManager();
        $this->repo=$repo;
    }
    
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
    #[Route('/register', name: 'app_register')]
    public function registerUser(Request $request){
        
        $user = new User();
        $form = $this->createForm(FormRegisterType::class,$user);
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            echo "subimite";
            $this->manager->persist($user);
            $this->manager->flush();
         return $this->redirectToRoute('app_guser');
        }
        return $this->render('Front/User/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/login', name: 'app_login')]
    public function showLogin(): Response
    {
        return $this->render('Front/user/login.html.twig');
    }

    #[Route('/gestionUser', name: 'app_guser')]
    public function showUserAdmin(): Response
    {
        $users=$this->repo->findall();
        return $this->render('Admin/user/users.html.twig',[
            'users' => $users,
        ]);
    }
    #[Route('/delete/{id}',name:'app_duser')]
    public function deleteUser($id,UserRepository $repository,ManagerRegistry $manager){
        $user = $repository->find($id);
        $this->manager->remove($user);
        $this->manager->flush();
        return $this->redirectToRoute('app_guser');


    }
    


}
