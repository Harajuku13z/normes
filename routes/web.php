<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\Admin\AdminAboutPageController;
use App\Http\Controllers\Admin\AdminAiServiceSettingsController;
use App\Http\Controllers\Admin\AdminAvisSettingsController;
use App\Http\Controllers\Admin\AdminBlogPostsController;
use App\Http\Controllers\Admin\AdminContactSettingsController;
use App\Http\Controllers\Admin\AdminFranchiseSettingsController;
use App\Http\Controllers\Admin\AdminHeaderSettingsController;
use App\Http\Controllers\Admin\AdminHomepageController;
use App\Http\Controllers\Admin\AdminLayoutSettingsController;
use App\Http\Controllers\Admin\AdminRealisationsHubController;
use App\Http\Controllers\Admin\AdminRealisationsPageController;
use App\Http\Controllers\Admin\AdminServicePagesController;
use App\Http\Controllers\Admin\AdminSimulateurSettingsController;
use App\Http\Controllers\Admin\AdminUserAuthController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\HomeAdminController;
use App\Http\Controllers\Admin\PortfolioProjectController;
use App\Http\Controllers\Admin\UploadController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EmailSignatureController;
use App\Http\Controllers\FranchiseController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LegacyPageController;
use App\Http\Controllers\RealisationsController;
use App\Http\Controllers\ServicePagesController;
use App\Http\Controllers\SimulateurController;
use App\Http\Controllers\SolarSimulatorController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\Admin\AdminContactInquiriesController;
use App\Http\Controllers\Admin\AdminEmailSignatureController;
use App\Http\Controllers\Admin\AdminLegacyPagesController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::controller(SitemapController::class)
    ->withoutMiddleware([
        \Illuminate\Cookie\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class,
    ])
    ->group(function (): void {
        Route::get('/sitemap_index.xml', 'index')->name('sitemap.index');
        Route::get('/sitemap.xml', 'index')->name('sitemap.alias');
        Route::get('/page-sitemap.xml', 'pages')->name('sitemap.pages');
        Route::get('/service-sitemap.xml', 'services')->name('sitemap.services');
        Route::get('/blog-sitemap.xml', 'blog')->name('sitemap.blog');
        Route::get('/realisation-sitemap.xml', 'realisations')->name('sitemap.realisations');
        Route::get('/legacy-sitemap.xml', 'legacy')->name('sitemap.legacy');
    });

Route::prefix('admin')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');

    Route::get('/adminuser/login', [AdminUserAuthController::class, 'showLogin'])->name('admin.adminuser.login');
    Route::post('/adminuser/login', [AdminUserAuthController::class, 'login'])->name('admin.adminuser.login.post');
    Route::post('/adminuser/logout', [AdminUserAuthController::class, 'logout'])->name('admin.adminuser.logout');

    Route::middleware('admin')->group(function () {
        Route::get('/', [HomeAdminController::class, 'index'])->name('admin.dashboard');
        Route::get('/section/{key}', [HomeAdminController::class, 'edit'])->name('admin.section.edit');
        Route::put('/section/{key}', [HomeAdminController::class, 'update'])->name('admin.section.update');
        Route::post('/upload', [UploadController::class, 'store'])->name('admin.upload');

        Route::get('/homepage', [AdminHomepageController::class, 'edit'])->name('admin.homepage.edit');
        Route::post('/homepage', [AdminHomepageController::class, 'update'])->name('admin.homepage.update');
        Route::get('/contact-settings', [AdminContactSettingsController::class, 'edit'])->name('admin.contact_settings.edit');
        Route::post('/contact-settings', [AdminContactSettingsController::class, 'update'])->name('admin.contact_settings.update');
        Route::get('/about-settings', [AdminAboutPageController::class, 'edit'])->name('admin.about_settings.edit');
        Route::post('/about-settings', [AdminAboutPageController::class, 'update'])->name('admin.about_settings.update');
        Route::get('/realisations', [AdminRealisationsHubController::class, 'index'])->name('admin.realisations.index');
        Route::get('/realisations/page', [AdminRealisationsPageController::class, 'edit'])->name('admin.realisations.page.edit');
        Route::post('/realisations/page', [AdminRealisationsPageController::class, 'update'])->name('admin.realisations.page.update');
        Route::get('/portfolio-projects', [PortfolioProjectController::class, 'index'])->name('admin.portfolio_projects.index');
        Route::get('/portfolio-projects/create', [PortfolioProjectController::class, 'create'])->name('admin.portfolio_projects.create');
        Route::post('/portfolio-projects', [PortfolioProjectController::class, 'store'])->name('admin.portfolio_projects.store');
        Route::get('/portfolio-projects/{portfolio_project}/edit', [PortfolioProjectController::class, 'edit'])->name('admin.portfolio_projects.edit');
        Route::put('/portfolio-projects/{portfolio_project}', [PortfolioProjectController::class, 'update'])->name('admin.portfolio_projects.update');
        Route::delete('/portfolio-projects/{portfolio_project}', [PortfolioProjectController::class, 'destroy'])->name('admin.portfolio_projects.destroy');
        Route::get('/layout-settings', [AdminLayoutSettingsController::class, 'edit'])->name('admin.layout_settings.edit');
        Route::post('/layout-settings', [AdminLayoutSettingsController::class, 'update'])->name('admin.layout_settings.update');
        Route::get('/header-settings', [AdminHeaderSettingsController::class, 'edit'])->name('admin.header_settings.edit');
        Route::post('/header-settings', [AdminHeaderSettingsController::class, 'update'])->name('admin.header_settings.update');
        Route::get('/avis-settings', [AdminAvisSettingsController::class, 'edit'])->name('admin.avis_settings.edit');
        Route::post('/avis-settings', [AdminAvisSettingsController::class, 'update'])->name('admin.avis_settings.update');
        Route::post('/avis-settings/fetch-google', [AdminAvisSettingsController::class, 'fetchGoogle'])->name('admin.avis_settings.fetch_google');
        Route::get('/franchise-settings', [AdminFranchiseSettingsController::class, 'edit'])->name('admin.franchise_settings.edit');
        Route::post('/franchise-settings', [AdminFranchiseSettingsController::class, 'update'])->name('admin.franchise_settings.update');
        Route::get('/ai-service-settings', [AdminAiServiceSettingsController::class, 'edit'])->name('admin.ai_service_settings.edit');
        Route::post('/ai-service-settings', [AdminAiServiceSettingsController::class, 'update'])->name('admin.ai_service_settings.update');
        Route::get('/simulateur-settings', [AdminSimulateurSettingsController::class, 'edit'])->name('admin.simulateur_settings.edit');
        Route::post('/simulateur-settings', [AdminSimulateurSettingsController::class, 'update'])->name('admin.simulateur_settings.update');
        Route::get('/simulateur-leads', [AdminSimulateurSettingsController::class, 'leads'])->name('admin.simulateur_leads.index');
        Route::get('/simulateur-leads/{simulateurLead}', [AdminSimulateurSettingsController::class, 'showLead'])->name('admin.simulateur_leads.show');
        Route::get('/simulateur-leads/{simulateurLead}/pdf', [AdminSimulateurSettingsController::class, 'leadPdf'])->name('admin.simulateur_leads.pdf');
        Route::post('/simulateur-leads/{simulateurLead}/resend-admin-mail', [AdminSimulateurSettingsController::class, 'resendAdminMail'])->name('admin.simulateur_leads.resend_admin_mail');
        Route::post('/simulateur-leads/{simulateurLead}/resend-client-mail', [AdminSimulateurSettingsController::class, 'resendClientMail'])->name('admin.simulateur_leads.resend_client_mail');
        Route::delete('/simulateur-leads/{simulateurLead}', [AdminSimulateurSettingsController::class, 'destroyLead'])->name('admin.simulateur_leads.destroy');

        Route::prefix('blog-posts')->name('admin.blog_posts.')->group(function () {
            Route::get('/', [AdminBlogPostsController::class, 'index'])->name('index');
            Route::get('/create', [AdminBlogPostsController::class, 'create'])->name('create');
            Route::post('/', [AdminBlogPostsController::class, 'store'])->name('store');
            Route::get('/{blogPost}/edit', [AdminBlogPostsController::class, 'edit'])->name('edit');
            Route::put('/{blogPost}', [AdminBlogPostsController::class, 'update'])->name('update');
            Route::delete('/{blogPost}', [AdminBlogPostsController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('legacy-pages')->name('admin.legacy_pages.')->group(function () {
            Route::get('/', [AdminLegacyPagesController::class, 'index'])->name('index');
            Route::get('/create', [AdminLegacyPagesController::class, 'create'])->name('create');
            Route::post('/', [AdminLegacyPagesController::class, 'store'])->name('store');
            Route::post('/import-wordpress', [AdminLegacyPagesController::class, 'importWordPress'])->name('import_wordpress');
            Route::get('/{legacyPage}/edit', [AdminLegacyPagesController::class, 'edit'])->name('edit');
            Route::put('/{legacyPage}', [AdminLegacyPagesController::class, 'update'])->name('update');
            Route::delete('/{legacyPage}', [AdminLegacyPagesController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('contact-inquiries')->name('admin.contact_inquiries.')->group(function () {
            Route::get('/', [AdminContactInquiriesController::class, 'index'])->name('index');
            Route::get('/{contactInquiry}', [AdminContactInquiriesController::class, 'show'])->name('show');
            Route::delete('/{contactInquiry}', [AdminContactInquiriesController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('email-signatures')->name('admin.email_signatures.')->group(function () {
            Route::get('/', [AdminEmailSignatureController::class, 'index'])->name('index');
            Route::get('/create', [AdminEmailSignatureController::class, 'create'])->name('create');
            Route::post('/', [AdminEmailSignatureController::class, 'store'])->name('store');
            Route::get('/{emailSignature}/edit', [AdminEmailSignatureController::class, 'edit'])->name('edit');
            Route::put('/{emailSignature}', [AdminEmailSignatureController::class, 'update'])->name('update');
            Route::delete('/{emailSignature}', [AdminEmailSignatureController::class, 'destroy'])->name('destroy');
        });
    });

    Route::middleware('elizo_adminuser')->group(function () {
        Route::get('/adminuser', [AdminUserController::class, 'index'])->name('admin.adminuser.index');
        Route::post('/adminuser', [AdminUserController::class, 'store'])->name('admin.adminuser.store');
    });
});

// Pages publiques dédiées aux services
Route::get('/services', [ServicePagesController::class, 'index'])->name('services.index');
Route::get('/services/{slug}', [ServicePagesController::class, 'show'])->name('service.page');

// Page publique contact (formulaire)
Route::get('/contact', [ContactController::class, 'index'])->name('contact.page');
Route::post('/contact', [ContactController::class, 'store'])
    ->middleware('throttle:6,1')
    ->name('contact.store');
Route::get('/contact/merci', [ContactController::class, 'success'])->name('contact.success');

// Page À propos
Route::get('/a-propos', [AboutController::class, 'index'])->name('about.page');

// Blog (articles)
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

// Franchise (candidature)
Route::get('/franchise', [FranchiseController::class, 'index'])->name('franchise.page');
Route::post('/franchise', [FranchiseController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('franchise.store');
Route::get('/franchise/merci', [FranchiseController::class, 'success'])->name('franchise.success');

// Réalisations (portfolio)
Route::get('/realisations', [RealisationsController::class, 'index'])->name('realisations.page');
Route::get('/realisations/{portfolio_project}', [RealisationsController::class, 'show'])->name('realisations.show');

// Simulateur solaire
Route::get('/simulateur-solaire', [SolarSimulatorController::class, 'index'])->name('simulateur.solaire');
Route::get('/simulateur-solaire/etape-4', [SolarSimulatorController::class, 'confirmation'])->name('simulateur.solaire.confirmation');
Route::post('/simulateur-solaire/etape-4', [SolarSimulatorController::class, 'storeConfirmation'])
    ->middleware('throttle:5,1')
    ->name('simulateur.solaire.confirmation.store');
Route::get('/simulateur-solaire/merci', [SolarSimulatorController::class, 'success'])->name('simulateur.solaire.success');
Route::get('/api/solar-demo-image', [SolarSimulatorController::class, 'demoImage'])
    ->middleware('throttle:30,1')
    ->name('api.solar.demoImage');
Route::get('/api/solar-autocomplete', [SolarSimulatorController::class, 'autocomplete'])
    ->middleware('throttle:60,1')
    ->name('api.solar.autocomplete');
Route::post('/api/solar-geocode', [SolarSimulatorController::class, 'geocode'])
    ->middleware('throttle:30,1')
    ->name('api.solar.geocode');
Route::post('/api/solar-estimate', [SolarSimulatorController::class, 'estimate'])
    ->middleware('throttle:20,1')
    ->name('api.solar.estimate');
Route::post('/api/solar-lead', [SolarSimulatorController::class, 'saveLead'])
    ->middleware('throttle:5,1')
    ->name('api.solar.lead');

// Simulateur de devis (multi-étapes)
Route::get('/simulateur', [SimulateurController::class, 'start'])->name('simulateur.start');
Route::get('/simulateur/etape-1', [SimulateurController::class, 'step1'])->name('simulateur.step1');
Route::post('/simulateur/etape-1', [SimulateurController::class, 'step1Store'])
    ->middleware('throttle:6,1')
    ->name('simulateur.step1.store');
Route::get('/simulateur/etape-2', [SimulateurController::class, 'step2'])->name('simulateur.step2');
Route::post('/simulateur/etape-2', [SimulateurController::class, 'step2Store'])->name('simulateur.step2.store');
Route::get('/simulateur/etape-3', [SimulateurController::class, 'step3'])->name('simulateur.step3');
Route::post('/simulateur/etape-3', [SimulateurController::class, 'step3Store'])->name('simulateur.step3.store');
Route::get('/simulateur/etape-4', [SimulateurController::class, 'step4'])->name('simulateur.step4');
Route::post('/simulateur/etape-4', [SimulateurController::class, 'step4Store'])->name('simulateur.step4.store');
Route::get('/simulateur/etape-5', [SimulateurController::class, 'step5'])->name('simulateur.step5');
Route::post('/simulateur/finaliser', [SimulateurController::class, 'finish'])
    ->middleware('throttle:6,1')
    ->name('simulateur.finish');
Route::get('/simulateur/ok', [SimulateurController::class, 'success'])->name('simulateur.success');

Route::get('/signature-mail/{emailSignature:slug}', [EmailSignatureController::class, 'show'])->name('email_signatures.show');
Route::get('/signature-mail/{emailSignature:slug}/html', [EmailSignatureController::class, 'html'])->name('email_signatures.html');
Route::get('/signature-mail/{emailSignature:slug}/download', [EmailSignatureController::class, 'download'])->name('email_signatures.download');

// Admin : pages dédiées aux services
Route::middleware('admin')->prefix('admin')->group(function () {
    Route::prefix('services-pages')->name('admin.services_pages.')->group(function () {
        Route::get('/', [AdminServicePagesController::class, 'index'])->name('index');
        Route::get('/create', [AdminServicePagesController::class, 'create'])->name('create');
        Route::post('/', [AdminServicePagesController::class, 'store'])->name('store');
        Route::post('/generate-ai', [AdminServicePagesController::class, 'generateWithAi'])->name('generate_ai');
        Route::get('/{servicePage}/edit', [AdminServicePagesController::class, 'edit'])->name('edit');
        Route::put('/{servicePage}', [AdminServicePagesController::class, 'update'])->name('update');
    });
});

// Legacy URLs from previous WordPress site served as real pages (200)
Route::get('/{path}', [LegacyPageController::class, 'showByPath'])
    ->where('path', '.*')
    ->name('legacy.show');
