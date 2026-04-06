<?php

declare(strict_types=1);

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use FortniteHub\Core\Controller;
use FortniteHub\Core\Router;

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
    /** @var Router */
    private $router;

    protected function setUp(): void
    {
        $this->router = new Router();

        if (!class_exists('FortniteHub\\Controllers\\TestController')) {
            class_alias(RouterDummyController::class, 'FortniteHub\\Controllers\\TestController');
        }

        RouterDummyController::$called = false;
        RouterDummyController::$receivedParams = [];
    }

    public function testCanBeInstantiated(): void
    {
        $this->assertInstanceOf(Router::class, $this->router);
    }

    public function testCanSetBasePath(): void
    {
        $this->router->setBasePath('/test/path');
        // No exception means success
        $this->assertTrue(true);
    }

    public function testCanAddGetRoute(): void
    {
        $this->router->get('/test', 'TestController', 'index');
        // No exception means success
        $this->assertTrue(true);
    }

    public function testCanAddPostRoute(): void
    {
        $this->router->post('/test', 'TestController', 'store');
        // No exception means success
        $this->assertTrue(true);
    }

    public function testCanDispatchRouteWithParams(): void
    {
        $this->router->get('/items/{id}', 'TestController', 'show');

        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/items/123';

        $this->router->dispatch();

        $this->assertTrue(RouterDummyController::$called);
        $this->assertSame(['123'], RouterDummyController::$receivedParams);
    }

    public function testDispatchSupportsBasePath(): void
    {
        $this->router->setBasePath('/fortnite/public');
        $this->router->get('/health', 'TestController', 'index');

        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/fortnite/public/health';

        $this->router->dispatch();

        $this->assertTrue(RouterDummyController::$called);
    }

    public function testMethodNotAllowedReturns405(): void
    {
        $this->router->get('/status', 'TestController', 'index');

        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_SERVER['REQUEST_URI'] = '/status';

        ob_start();
        $this->router->dispatch();
        ob_end_clean();

        $this->assertSame(405, http_response_code());
    }

    public function testNotFoundReturns404(): void
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/route-that-does-not-exist';

        ob_start();
        $this->router->dispatch();
        ob_end_clean();

        $this->assertSame(404, http_response_code());
    }
}
