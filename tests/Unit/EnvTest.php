<?php

declare(strict_types=1);

namespace Tests\Unit;

use FortniteHub\Core\Env;
use PHPUnit\Framework\TestCase;

class EnvTest extends TestCase
{
    /**
     * @var array<int, string>
     */
    private array $keys = [
        'ENV_TEST_KEY',
        'ENV_TEST_EXPORTED',
        'ENV_TEST_COMMENT',
        'ENV_TEST_HASH',
        'ENV_TEST_ESCAPED',
        'ENV_TEST_PRESET',
    ];

    protected function setUp(): void
    {
        Env::reset();

        foreach ($this->keys as $key) {
            unset($_ENV[$key], $_SERVER[$key]);
            putenv($key);
        }
    }

    protected function tearDown(): void
    {
        foreach ($this->keys as $key) {
            unset($_ENV[$key], $_SERVER[$key]);
            putenv($key);
        }

        Env::reset();
    }

    public function testLoadsSimpleKeyValue(): void
    {
        $file = $this->makeEnvFile("ENV_TEST_KEY=ok\n");
        Env::load($file);

        $this->assertSame('ok', Env::get('ENV_TEST_KEY'));

        unlink($file);
    }

    public function testSupportsExportPrefixAndInlineComments(): void
    {
        $content = "export ENV_TEST_EXPORTED=active\nENV_TEST_COMMENT=value # inline comment\n";
        $file = $this->makeEnvFile($content);

        Env::load($file);

        $this->assertSame('active', Env::get('ENV_TEST_EXPORTED'));
        $this->assertSame('value', Env::get('ENV_TEST_COMMENT'));

        unlink($file);
    }

    public function testKeepsHashesInsideQuotedValues(): void
    {
        $content = "ENV_TEST_HASH=\"token#v1\"\nENV_TEST_ESCAPED=\"line1\\nline2\"\n";
        $file = $this->makeEnvFile($content);

        Env::load($file);

        $this->assertSame('token#v1', Env::get('ENV_TEST_HASH'));
        $this->assertSame("line1\nline2", Env::get('ENV_TEST_ESCAPED'));

        unlink($file);
    }

    public function testDoesNotOverwritePredefinedRuntimeVariable(): void
    {
        putenv('ENV_TEST_PRESET=runtime');
        $_ENV['ENV_TEST_PRESET'] = 'runtime';

        $file = $this->makeEnvFile("ENV_TEST_PRESET=file\n");
        Env::load($file);

        $this->assertSame('runtime', Env::get('ENV_TEST_PRESET'));

        unlink($file);
    }

    private function makeEnvFile(string $content): string
    {
        $file = tempnam(sys_get_temp_dir(), 'fnh_env_');
        if ($file === false) {
            $this->fail('Could not create temporary env file.');
        }

        file_put_contents($file, $content);
        return $file;
    }
}
