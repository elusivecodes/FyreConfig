<?php
declare(strict_types=1);

namespace Tests;

use Fyre\Config\Config;
use Fyre\Utility\Path;
use PHPUnit\Framework\TestCase;

final class ConfigTest extends TestCase
{

    public function testAddPath(): void
    {
        Config::addPath('tests/config/dir1');
        Config::load('config');

        $this->assertSame(
            'Value 1',
            Config::get('value')
        );
    }

    public function testAddPaths(): void
    {
        Config::addPath('tests/config/dir1');
        Config::addPath('tests/config/dir2');
        Config::load('config');

        $this->assertSame(
            'Value 2',
            Config::get('value')
        );
    }

    public function testAddPathPrepend(): void
    {
        Config::addPath('tests/config/dir1');
        Config::addPath('tests/config/dir2', true);
        Config::load('config');

        $this->assertSame(
            'Value 1',
            Config::get('value')
        );
    }

    public function testAddPathDuplicate(): void
    {
        Config::addPath('tests/config/dir1');
        Config::addPath('tests/config/dir2');
        Config::addPath('tests/config/dir1');

        $this->assertSame(
            [
                Path::resolve('tests/config/dir1'),
                Path::resolve('tests/config/dir2')
            ],
            Config::getPaths()
        );
    }

    public function testAddPathPrependDuplicate(): void
    {
        Config::addPath('tests/config/dir1');
        Config::addPath('tests/config/dir2');
        Config::addPath('tests/config/dir2', true);

        $this->assertSame(
            [
                Path::resolve('tests/config/dir1'),
                Path::resolve('tests/config/dir2')
            ],
            Config::getPaths()
        );
    }

    public function testConsume(): void
    {
        Config::set('test', 'Test');

        $this->assertSame(
            'Test',
            Config::consume('test')
        );

        $this->assertFalse(
            Config::has('test')
        );
    }

    public function testConsumeDeep(): void
    {
        Config::set('test.deep', 'Test');

        $this->assertSame(
            'Test',
            Config::consume('test.deep')
        );

        $this->assertFalse(
            Config::has('test.deep')
        );
    }

    public function testConsumeInvalid(): void
    {
        $this->assertNull(
            Config::consume('test')
        );
    }

    public function testConsumeDefault(): void
    {
        $this->assertSame(
            'Test',
            Config::consume('test', 'Test')
        );
    }

    public function testDelete(): void
    {
        Config::set('test', 'Test');

        $this->assertTrue(
            Config::delete('test')
        );

        $this->assertNull(
            Config::get('test')
        );
    }

    public function testDeleteDeep(): void
    {
        Config::set('test.deep', 'Test');

        $this->assertTrue(
            Config::delete('test.deep')
        );

        $this->assertNull(
            Config::get('test.deep')
        );
    }

    public function testDeleteInvalid(): void
    {
        $this->assertFalse(
            Config::delete('test')
        );
    }

    public function testGetDeep(): void
    {
        Config::set('test.deep', 'Test');

        $this->assertSame(
            'Test',
            Config::get('test.deep')
        );
    }

    public function testGetInvalid(): void
    {
        $this->assertNull(
            Config::get('test')
        );
    }

    public function testGetDefault(): void
    {
        $this->assertSame(
            'Test',
            Config::get('test', 'Test')
        );
    }

    public function testHas(): void
    {
        Config::set('test', 'Test');

        $this->assertTrue(
            Config::has('test')
        );
    }

    public function testHasInvalid(): void
    {
        $this->assertFalse(
            Config::has('test')
        );
    }

    public function testRemovePath(): void
    {
        Config::addPath('tests/config/dir1');

        $this->assertTrue(
            Config::removePath('tests/config/dir1')
        );

        $this->assertEmpty(
            Config::getPaths()
        );
    }

    public function testRemovePathInvalid(): void
    {
        $this->assertFalse(
            Config::removePath('tests/config/dir1')
        );
    }

    public function testSet(): void
    {
        Config::set('test', 'Test');

        $this->assertSame(
            'Test',
            Config::get('test')
        );
    }

    public function testSetDeep(): void
    {
        Config::set('test.deep', 'Test');

        $this->assertSame(
            [
                'deep' => 'Test'
            ],
            Config::get('test')
        );
    }

    public function testSetOverwrite(): void
    {
        Config::set('test', 'Test 1');
        Config::set('test', 'Test 2', false);

        $this->assertSame(
            'Test 1',
            Config::get('test')
        );
    }

    protected function setUp(): void
    {
        Config::clear();
    }

}
