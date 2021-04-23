<?php
 namespace App\Controller\Site;

use App\Entity\Site;
use App\Form\SiteType;
use App\Repository\SiteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SiteController extends AbstractController
{ 
    /**
    * @var SiteRepository
    */
    private $repository;
    /**
    * @var EntityManagerInterface
    */
    private $em;

    public function __construct(SiteRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }
 
    /**
    *@Route("/site", name="admin.site.index") 
    * @return \Symfony\Component\HttpFoundation\Response
    */
     public function index()
    {
        $site = $this->repository->findAll();
        return $this->render('admin/site/index.php.twig', compact('site'));
    } 

    /**
    *@Route("/admin/site/create", name="admin.site.ajout")
    */
     public function ajout(Request $request)
    {
        $site = new Site();
        $form = $this->createForm(SiteType::class, $site);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->em->persist($site);
            $this->em->flush();
            $this->addFlash('success', 'Bien ajouté avec succès');
            return $this->redirectToRoute('admin.site.index');
        }

        return $this->render('admin/site/ajout.php.twig', [
            'site' => $site,
            'form' => $form->createView()
        ]);

    }
    
    /**
     * @Route("/admin/si/{id}", name="site_show", methods={"GET"})
     */
    public function show(Site $site): Response
    {
        return $this->render('/admin/site/show.html.twig', [
            'site' => $site,
        ]);
    }

    /**
    *@Route("/admin/site/{id}", name="admin.site.edit", methods="GET|POST")
    *@param Site $site
    *@param Request $request
    * @return \Symfony\Component\HttpFoundation\Response 
    */
     public function edit(Site $site, Request $request)
    {
        $form = $this->createForm(SiteType::class, $site);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->em->flush();
            $this->addFlash('success', 'Bien modifié avec succès');
            return $this->redirectToRoute('admin.site.index');
        }

        return $this->render('admin/site/edit.php.twig', [
            'site' => $site,
            'form' => $form->createView()
        ]);
    }

    /**
    *@Route("/admin/site/{id}", name="admin.site.delete", methods="DELETE")
    *@param Site $site
    * @return \Symfony\Component\HttpFoundation\RedirectResponse 
    */
     public function delete(Site $site, Request $request)
    {   
        dump('supppression');
        if($this->isCsrfTokenValid('delete'. $site->getId(), $request->get('_token')))
        {
            $this->em->remove($site);
            $this->em->flush();
            $this->addFlash('success', 'Bien supprimé avec succès');
        }
        return $this->redirectToRoute('admin.site.index');
    }
} 