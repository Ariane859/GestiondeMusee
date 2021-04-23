<?php
namespace App\Controller\Admin;

use App\Entity\Pays;
use App\Form\PaysType;
use App\Repository\PaysRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminPaysController extends AbstractController
{
    /**
    * @var PaysRepository
    */
    private $repository;
    /**
    * @var EntityManagerInterface
    */
    private $em;

    public function __construct(PaysRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
    *@Route("/admin", name="admin.pays.index") 
    * @return \Symfony\Component\HttpFoundation\Response
    */
    public function index()
    {
        $pays = $this->repository->findAll();
        return $this->render('admin/pays/index.php.twig', compact('pays'));
    }

    /**
    *@Route("/admin/pays/create", name="admin.pays.ajout")
    */
    public function ajout(Request $request)
    {
        $pays = new Pays();
        $form = $this->createForm(PaysType::class, $pays);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->em->persist($pays);
            $this->em->flush();
            $this->addFlash('success', 'Bien ajouté avec succès');
            return $this->redirectToRoute('admin.pays.index');
        }

        return $this->render('admin/pays/ajout.php.twig', [
            'pays' => $pays,
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/admin/pa/{id}", name="pays_show", methods={"GET"})
     */
    public function show(Pays $pays): Response
    {
        return $this->render('/admin/pays/show.html.twig', [
            'pays' => $pays,
        ]);
    }

    /**
    *@Route("/admin/pays/{id}", name="admin.pays.edit", methods="GET|POST")
    *@param Pays $pays
    *@param Request $request
    * @return \Symfony\Component\HttpFoundation\Response 
    */
    public function edit(Pays $pays, Request $request)
    {
        $form = $this->createForm(PaysType::class, $pays);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->em->flush();
            $this->addFlash('success', 'Bien modifié avec succès');
            return $this->redirectToRoute('admin.pays.index');
        }

        return $this->render('admin/pays/edit.php.twig', [
            'pays' => $pays,
            'form' => $form->createView()
        ]);
    }

    /**
    *@Route("/admin/pays/{id}", name="admin.pays.delete", methods="DELETE")
    *@param Pays $pays
    * @return \Symfony\Component\HttpFoundation\RedirectResponse 
    */
    public function delete(Pays $pays, Request $request)
    {   
        dump('supppression');
        if($this->isCsrfTokenValid('delete'. $pays->getId(), $request->get('_token')))
        {
            $this->em->remove($pays);
            $this->em->flush();
            $this->addFlash('success', 'Bien supprimé avec succès');
        }
        return $this->redirectToRoute('admin.pays.index');
    }
}