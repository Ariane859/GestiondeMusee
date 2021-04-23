<?php
namespace App\Controller\Ouvrage;

use App\Entity\Ouvrage;
use App\Form\OuvrageType;
use App\Repository\OuvrageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OuvrageController extends AbstractController
{ 
    /**
    * @var OuvrageRepository
    */
     private $repository;
    /**
    * @var EntityManagerInterface
    */
    private $em;

     public function __construct(OuvrageRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    } 

    /**
    *@Route("/ouvrage", name="admin.ouvrage.index") 
    * @return \Symfony\Component\HttpFoundation\Response
    */
     public function index()
    {
        $ouvrage = $this->repository->findAll();
        return $this->render('admin/ouvrage/index.php.twig', compact('ouvrage'));
    } 

    /**
    *@Route("/admin/ouvrage/create", name="admin.ouvrage.ajout")
    */
     public function ajout(Request $request)
    {
        $ouvrage = new Ouvrage();
        $form = $this->createForm(OuvrageType::class, $ouvrage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->em->persist($ouvrage);
            $this->em->flush();
            $this->addFlash('success', 'Bien ajouté avec succès');
            return $this->redirectToRoute('admin.ouvrage.index');
        }

        return $this->render('admin/ouvrage/ajout.php.twig', [
            'ouvrage' => $ouvrage,
            'form' => $form->createView()
        ]);

    } 

    /**
     * @Route("/admin/ou/{id}", name="ouvrage_show", methods={"GET"})
     */
    public function show(Ouvrage $ouvrage): Response
    {
        return $this->render('/admin/ouvrage/show.html.twig', [
            'ouvrage' => $ouvrage,
        ]);
    }

    /**
    *@Route("/admin/ouvrage/{id}", name="admin.ouvrage.edit", methods="GET|POST")
    *@param Ouvrage $ouvrage
    *@param Request $request
    * @return \Symfony\Component\HttpFoundation\Response 
    */
     public function edit(Ouvrage $ouvrage, Request $request)
    {
        $form = $this->createForm(OuvrageType::class, $ouvrage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->em->flush();
            $this->addFlash('success', 'Bien modifié avec succès');
            return $this->redirectToRoute('admin.ouvrage.index');
        }

        return $this->render('admin/ouvrage/edit.php.twig', [
            'ouvrage' => $ouvrage,
            'form' => $form->createView()
        ]);
    }
 
    /**
    *@Route("/admin/ouvrage/{id}", name="admin.ouvrage.delete", methods="DELETE")
    *@param Ouvrage $ouvrage
    * @return \Symfony\Component\HttpFoundation\RedirectResponse 
    */
     public function delete(Ouvrage $ouvrage, Request $request)
    {   
        dump('suppression');
        if($this->isCsrfTokenValid('delete'. $ouvrage->getId(), $request->get('_token')))
        {
            $this->em->remove($ouvrage);
            $this->em->flush();
            $this->addFlash('success', 'Bien supprimé avec succès');
        }
        return $this->redirectToRoute('admin.ouvrage.index');
    }
} 