<?php

namespace App\Controller\Admin;

use App\Entity\LigneProduitFournisseur;
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
//        $first_role = 'user';
        if($this->rs->getSession()->get('_role')==null)
            $this->rs->getSession()->set('_role', $first_role);
  
        $this->current_role = $this->rs->getSession()->get('_role');
    }

    #[Route('/admin', name: 'dashboard')]
    public function index(): Response
    {
        return parent::index();
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
        yield MenuItem::linkToCrud('User', 'fa fa-users', User::class)
            ->setPermission('ROLE_ADMIN');
        yield MenuItem::linkToCrud('Facture Fournisseur', ' fas fa-file-invoice-dollar', FactureFournisseur::class);
        yield MenuItem::linkToCrud('Facture Client', ' fas fa-file-invoice-dollar', FactureClient::class)
            ->setPermission('ROLE_ADMIN');
        yield MenuItem::linkToCrud('Fourniseur', 'fas fa-truck', Fournisseur::class)
            ->setPermission('ROLE_ADMIN');
        yield MenuItem::linkToCrud('Produit', 'fas fa-shopping-cart',Produit::class)
            ->setPermission('ROLE_ADMIN');
        yield MenuItem::linkToCrud('Service', 'fas fa-wrench',Service::class)
            ->setPermission('ROLE_ADMIN');
        yield MenuItem::linkToCrud('Client', 'fa fa-user',Client::class)
            ->setPermission('ROLE_ADMIN');
        yield MenuItem::linkToCrud('Workflow Paiements', 'fa fa-retweet', WorkflowPaiements::class)
            ->setPermission('ROLE_ADMIN');
        yield MenuItem::linkToRoute('Statistiques', 'fa fa-bar-chart', 'stats')
            ->setPermission('ROLE_ADMIN');

        // Pour le rôle ROLE_COMPTABLE
        yield MenuItem::linkToCrud('Facture Client', 'fas fa-file-invoice-dollar', FactureClient::class)
            ->setPermission('ROLE_COMPTABLE');

        yield MenuItem::linkToCrud('Fourniseur', 'fas fa-truck', Fournisseur::class)
            ->setPermission('ROLE_COMPTABLE');

        yield MenuItem::linkToCrud('Produit', 'fas fa-shopping-cart',Produit::class)
            ->setPermission('ROLE_COMPTABLE');

        yield MenuItem::linkToCrud('Service', 'fas fa-wrench',Service::class)
            ->setPermission('ROLE_COMPTABLE');

        yield MenuItem::linkToCrud('Client', 'fa fa-user',Client::class)
            ->setPermission('ROLE_COMPTABLE');

        yield MenuItem::linkToCrud('Workflow Paiements', 'fa fa-retweet', WorkflowPaiements::class)
            ->setPermission('ROLE_COMPTABLE');

        yield MenuItem::linkToRoute('Statistiques', 'fa fa-bar-chart', 'stats')
            ->setPermission('ROLE_COMPTABLE');

    }
}
