<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class PortfolioTest extends TestCase
{
    public static function pages(): array
    {
        return [['/'], ['/about'], ['/services'], ['/products'], ['/products/nexa'], ['/contact']];
    }

    #[DataProvider('pages')]
    public function test_pages_render_with_branding_and_local_assets(string $path): void
    {
        $response = $this->get($path);
        $response->assertOk()->assertSee('Nexus Qart')->assertSee('Skip to content');
        $response->assertDontSee('NeuroQR')->assertDontSee('Wooperly');

        $document = new \DOMDocument;
        @$document->loadHTML($response->getContent());
        $this->assertCount(1, $document->getElementsByTagName('h1'));
        foreach ($document->getElementsByTagName('img') as $image) {
            $asset = parse_url($image->getAttribute('src'), PHP_URL_PATH);
            $this->assertFileExists(public_path(ltrim($asset, '/')));
        }
    }

    public function test_product_links_to_the_separate_application(): void
    {
        $this->get('/products/nexa')
            ->assertOk()
            ->assertSee('https://getwooperly.com/login')
            ->assertSee('assets/nexa-menu.png')
            ->assertSee('assets/nexa-assistant.png')
            ->assertSee('PLANNED CAPABILITIES')
            ->assertSee('$7')->assertSee('$11');
        $this->get('/products/wooperly')->assertStatus(301)->assertRedirect('/products/nexa');
        $this->get('/login')->assertNotFound();
    }

    public function test_contact_uses_configured_email_and_encodes_the_interest(): void
    {
        config(['portfolio.contact_email' => 'hello@example.com']);
        $this->get('/contact?interest='.rawurlencode('QR menu & demo'))
            ->assertOk()
            ->assertSee('mailto:hello@example.com?subject='.rawurlencode('Nexus Qart — QR menu & demo'), false);
        $this->get('/contact?interest[]=bad')->assertOk();
        $this->get('/contact?interest='.rawurlencode('<script>alert(1)</script>'))
            ->assertOk()->assertDontSee('<script>alert(1)</script>', false);
    }

    public function test_legacy_routes_redirect_and_unknown_pages_return_404(): void
    {
        $this->get('/company')->assertStatus(301)->assertRedirect('/about');
        $this->get('/products/intelligent-qr')->assertStatus(301)->assertRedirect('/products/nexa');
        $this->get('/pricing')->assertStatus(301)->assertRedirect('/products/nexa');
        foreach ([
            '/index.html' => '/',
            '/products/index.html' => '/products',
            '/products/intelligent-qr/index.html' => '/products/nexa',
            '/services/index.html' => '/services',
            '/pricing/index.html' => '/products/nexa',
            '/company/index.html' => '/about',
            '/contact/index.html' => '/contact',
        ] as $oldPath => $destination) {
            $this->get($oldPath)->assertStatus(301)->assertRedirect($destination);
        }
        $this->get('/missing')->assertNotFound()->assertSee('Back to home');
    }

    public function test_health_endpoint_is_available_without_a_database(): void
    {
        $this->get('/up')->assertOk();
    }
}
