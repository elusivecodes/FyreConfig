<?php
declare(strict_types=1);

namespace Tests;

use
    Fyre\Config\Config,
    PHPUnit\Framework\TestCase;

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
        Config::delete('test');

        $this->assertNull(
            Config::get('test')
        );
    }

    public function testDeleteDeep(): void
    {
        Config::set('test.deep', 'Test');
        Config::delete('test.deep');

        $this->assertNull(
            Config::get('test.deep')
        );
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testDeleteInvalid(): void
    {
        Config::delete('test');
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
