<?php 
 namespace App\Controller\Bibliotheque;

use App\Entity\Bibliotheque;
use App\Form\BibliothequeType;
use App\Repository\BibliothequeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BibliothequeController extends AbstractController
{
    /**
    * @var BibliothequeRepository
    */
     private $repository;
    /**
    * @var EntityManagerInterface
    */
    private $em;

     public function __construct(BibliothequeRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    } 

    /**
    *@Route("/bibliotheque", name="admin.bibliotheque.index") 
    * @return \Symfony\Component\HttpFoundation\Response
    */
     public function index()
    {
        $bibliotheque = $this->repository->findAll();
        return $this->render('admin/bibliotheque/index.php.twig', compact('bibliotheque'));
    } 

    /**
    *@Route("/admin/bibliotheque/create", name="admin.bibliotheque.ajout")
    */
     public function ajout(Request $request)
    {
        $bibliotheque = new Bibliotheque();
        $form = $this->createForm(BibliothequeType::class, $bibliotheque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->em->persist($bibliotheque);
            $this->em->flush();
            $this->addFlash('success', 'Bien ajouté avec succès');
            return $this->redirectToRoute('admin.bibliotheque.index');
        }

        return $this->render('admin/bibliotheque/ajout.php.twig', [
            'bibliotheque' => $bibliotheque,
            'form' => $form->createView()
        ]);

    } 

    /**
     * @Route("/admin/bi/{id}", name="bibliotheque_show", methods={"GET"})
     */
    public function show(Bibliotheque $bibliotheque): Response
    {
        return $this->render('/admin/bibliotheque/show.html.twig', [
            'bibliotheque' => $bibliotheque,
        ]);
    }

    /**
    *@Route("/admin/bibliotheque/{id}", name="admin.bibliotheque.edit", methods="GET|POST")
    *@param Bibliotheque $bibliotheque
    *@param Request $request
    * @return \Symfony\Component\HttpFoundation\Response 
    */
    public function edit(Bibliotheque $bibliotheque, Request $request)
    {
        $form = $this->createForm(BibliothequeType::class, $bibliotheque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->em->flush();
            $this->addFlash('success', 'Bien modifié avec succès');
            return $this->redirectToRoute('admin.bibliotheque.index');
        }

        return $this->render('admin/bibliotheque/edit.php.twig', [
            'bibliotheque' => $bibliotheque,
            'form' => $form->createView()
        ]);
    }

    /**
    *@Route("/admin/bibliotheque/{id}", name="admin.bibliotheque.delete", methods="DELETE")
    *@param Bibliotheque $bibliotheque
    * @return \Symfony\Component\HttpFoundation\RedirectResponse 
    */
     public function delete(Bibliotheque $bibliotheque, Request $request)
    {   
        dump('suppression');
        if($this->isCsrfTokenValid('delete'. $bibliotheque->getId(), $request->get('_token')))
        {
            $this->em->remove($bibliotheque);
            $this->em->flush();
            $this->addFlash('success', 'Bien supprimé avec succès');
        }
        return $this->redirectToRoute('admin.bibliotheque.index');
    }
} 