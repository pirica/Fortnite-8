<?php

declare(strict_types=1);

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use FortniteHub\Core\Controller;

final class RouterDummyController extends Controller
{
    public static bool $called = false;

    /**
     * @var array<int, string>
     */
    public static array $receivedParams = [];

    public function index(): void
    {
        self::$called = true;
    }

    public function show(string $id): void
    {
        self::$called = true;
        self::$receivedParams = [$id];
    }
}

/**
 * Router Unit Tests
 */
class RouterTest extends TestCase
{
    protected function setUp(): void
    {
        if (!class_exists('FortniteHub\\Controllers\\TestController')) {
            class_alias(RouterDummyController::class, 'FortniteHub\\Controllers\\TestController');
        }

        RouterDummyController::$called = false;
        RouterDummyController::$receivedParams = [];
    }

    private function makeRouter(): \FortniteHub\Core\Router
    {
        return new \FortniteHub\Core\Router();
    }

    public function testCanBeInstantiated(): void
    {
        $this->assertInstanceOf(\FortniteHub\Core\Router::class, $this->makeRouter());
    }

    public function testCanSetBasePath(): void
    {
        $router = $this->makeRouter();
        $router->setBasePath('/test/path');
        // No exception means success
        $this->assertTrue(true);
    }

    public function testCanAddGetRoute(): void
    {
        $router = $this->makeRouter();
        $router->get('/test', 'TestController', 'index');
        // No exception means success
        $this->assertTrue(true);
    }

    public function testCanAddPostRoute(): void
    {
        $router = $this->makeRouter();
        $router->post('/test', 'TestController', 'store');
        // No exception means success
        $this->assertTrue(true);
    }

    public function testCanDispatchRouteWithParams(): void
    {
        $router = $this->makeRouter();
        $router->get('/items/{id}', 'TestController', 'show');

        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/items/123';

        $router->dispatch();

        $this->assertTrue(RouterDummyController::$called);
        $this->assertSame(['123'], RouterDummyController::$receivedParams);
    }

    public function testDispatchSupportsBasePath(): void
    {
        $router = $this->makeRouter();
        $router->setBasePath('/fortnite/public');
        $router->get('/health', 'TestController', 'index');

        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/fortnite/public/health';

        $router->dispatch();

        $this->assertTrue(RouterDummyController::$called);
    }

    public function testMethodNotAllowedReturns405(): void
    {
        $router = $this->makeRouter();
        $router->get('/status', 'TestController', 'index');

        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_SERVER['REQUEST_URI'] = '/status';

        ob_start();
        $router->dispatch();
        ob_end_clean();

        $this->assertSame(405, http_response_code());
    }

    public function testNotFoundReturns404(): void
    {
        $router = $this->makeRouter();

        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/route-that-does-not-exist';

        ob_start();
        $router->dispatch();
        ob_end_clean();

        $this->assertSame(404, http_response_code());
    }
}
