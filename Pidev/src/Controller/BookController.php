<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    //Fonction 1 :Affichage des livres =>Un fichier (ListBook.html.twig)
    #[Route('/listBook', name: 'list_book')]
    public function listBook(BookRepository $bookrepository): Response
    {
    
        return $this->render('book/listBook.html.twig', [
            'books' => $bookrepository->findAll(),
        ]);
    }

    //Fonction 2 :Ajouter un  livre  =>Un fichier (AddBook.html.twig) + un formulaire
    #[Route('/addbook', name: 'add_book')]
    public function addBook(ManagerRegistry $manager, Request $request): Response
    {
        $em = $manager->getManager();

        $book = new Book();

        $form = $this->createForm(BookType::class, $book);


        $form->handleRequest($request);
        if ($form->isSubmitted()) {

            $book->setPublished(true);
            //Incrémentation nombre des livres pour chaque auteur
            $nb =  $book->getAuthor()->getNbbooks() + 1;
            $book->getAuthor()->setNbbooks($nb);
            //---------------------------------------------------


            $em->persist($book);
            $em->flush();

            return $this->redirectToRoute('list_book');
        }


        return $this->renderForm('book/addBook.html.twig', ['form3A59' => $form]);
    }

    //Fonction 3 : Modifier un livre  =>Un fichier (editBook.html.twig) + un formulaire
    #[Route('/editBook/{id}', name: 'book_edit')]
    public function editBook(Request $request, ManagerRegistry $manager, $id, BookRepository $bookrepository): Response
    {
        $em = $manager->getManager();

        $book  = $bookrepository->find($id);
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            
            $em->persist($book);
            $em->flush();
            return $this->redirectToRoute('list_book');
        }

        return $this->renderForm('book/editBook.html.twig', [
            'book' => $book,
            'form3A59V2' => $form,
        ]);
    }
    //Fonction 4: Supprimer livre 
    #[Route('/deleteBook/{id}', name: 'book_delete')]
    public function deleteBook($id, ManagerRegistry $manager, BookRepository $bookRepository): Response
    {
        $em = $manager->getManager();
        $book = $bookRepository->find($id);

        $em->remove($book);
        $em->flush();

        return $this->redirectToRoute('list_book');
    }
    //Fonction 5: Afficher les details d'un seul livre =>Un fichier (showDetails.html.twig)
    #[Route('/book/{id}', name: 'book_details')]
    public function show(BookRepository $bookrepository, $id): Response
    {
        return $this->render('book/showDetails.html.twig', [
            'book' => $bookrepository->find($id),
        ]);
    }
}
