<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\Client;
use App\Entity\FactureClient;
use App\Entity\User;
use App\Entity\Fournisseur;
use App\Entity\FactureFournisseur;
use App\Entity\Produit;
use App\Entity\Service;
use App\Entity\LigneProduitClient;
use App\Entity\WorkflowPaiements;
use Symfony\Component\HttpFoundation\RequestStack;

use Symfony\Component\Security\Core\Security;
class DashboardController extends AbstractDashboardController
{
    public function __construct(RequestStack $requestStack, Security $security)
    {
        $this->rs = $requestStack;
        $first_role = $security->getUser()->getRoles()[0];
        if($this->rs->getSession()->get('_role')==null)
            $this->rs->getSession()->set('_role', $first_role);
  
        $this->current_role = $this->rs->getSession()->get('_role');
    }
    #[Route('/admin', name: 'dashboard')]
    public function index(): Response
    {
        return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('gestionfacture');
    }
    public function configureUserMenu(UserInterface $user): UserMenu
    {
        return parent::configureUserMenu($user)
            ->setName($user->getUserIdentifier())
            ->setGravatarEmail($user->getEmail())
         //   ->setAvatarUrl('https://www.clipartmax.com/png/full/405-4050774_avatar-icon-flat-icon-shop-download-free-icons-for-avatar-icon-flat.png')
            ->displayUserAvatar(true);
    }



    public function configureAssets(): Assets
    {
        return Assets::new()->addCssFile('build/css/admin.css');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
        yield MenuItem::linkToCrud('User', 'fas fa-list', User::class);
       

        yield MenuItem::linkToCrud('Facture Fournisseur', 'fas fa-list', FactureFournisseur::class);
        yield MenuItem::linkToCrud('Facture Client', 'fas fa-list', FactureClient::class);
       
        yield MenuItem::linkToCrud('Fourniseur', 'fas fa-list', Fournisseur::class);
        yield MenuItem::linkToCrud('Produit', 'fas fa-list',Produit::class);
        
        yield MenuItem::linkToCrud('Service', 'fas fa-list',Service::class);
        yield MenuItem::linkToCrud('Ligne Produit Client', 'fas fa-list',LigneProduitClient::class);
        yield MenuItem::linkToCrud('Client', 'fas fa-list',Client::class);
        yield MenuItem::linkToCrud('Workflow Paiements', 'fas fa-list', WorkflowPaiements::class);
      
      
     
    }
}
