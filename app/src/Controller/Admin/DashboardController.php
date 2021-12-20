<?php

namespace App\Controller\Admin;

use App\Entity\{
    Category, Product, User
};
use EasyCorp\Bundle\EasyAdminBundle\{Config\Dashboard,
    Config\MenuItem,
    Controller\AbstractDashboardController,
    Router\AdminUrlGenerator,
    Router\CrudUrlGenerator};
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[IsGranted('ROLE_MANAGER')]
class DashboardController extends AbstractDashboardController
{
    private AdminUrlGenerator $adminUrlGenerator;

    public function __construct(AdminUrlGenerator $adminUrlGenerator)
    {
        $this->adminUrlGenerator = $adminUrlGenerator;
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $productListUrl = $this->adminUrlGenerator
            ->setController(ProductCrudController::class)
            ->generateUrl();

        return $this->redirect($productListUrl);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('CRT Symfony #4');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');

        yield MenuItem::linkToCrud('Categories', 'fas fa-tags', Category::class);
        yield MenuItem::linkToCrud('Products', 'fas fa-th-list', Product::class)
            ->setDefaultSort(['createdAt' => 'DESC']);

        if ($this->isGranted('ROLE_ADMIN')) {
            yield MenuItem::linkToCrud('Users', 'fas fa-users', User::class);
        }

        yield MenuItem::section('About Me', 'fas fa-folder-open');
        yield MenuItem::linkToUrl('Github Home', 'fas fa-home', 'https://github.com/linbis/crt-symfony-4')
            ->setLinkTarget('_blank')
            ->setLinkRel('noreferrer');
    }
}