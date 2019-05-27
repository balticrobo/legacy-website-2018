<?php declare(strict_types=1);

namespace BalticRobo\Website\Tests\Unit\Adapter\Enum;

use BalticRobo\Website\Adapter\Enum\InformationTypeEnum;
use BalticRobo\Website\Adapter\Enum\UnknownEnumException;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

final class InformationTypeEnumTest extends TestCase
{
    /** @test */
    public function itDisallowToCreateInstance(): void
    {
        $this->expectException(\Error::class);

        new InformationTypeEnum();
    }

    public function testGetName(): void
    {
        $name = InformationTypeEnum::getName(1);

        Assert::assertSame('enum.information_type.hotel', $name);
    }

    public function testGetNameWithIncorrectEnum(): void
    {
        $this->expectException(UnknownEnumException::class);
        $this->expectExceptionMessage('Unknown enum key: 2.');

        InformationTypeEnum::getName(2);
    }

    public function testGetFormData(): void
    {
        $formData = InformationTypeEnum::getFormData();

        Assert::assertSame([
            'enm.information_type.info' => '0',
            'enum.information_type.hotel' => '1'
        ], $formData);
    }

    public function testGetAvailableTypes(): void
    {
        $availableTypes = InformationTypeEnum::getAvailableTypes();

        Assert::assertSame([0, 1], $availableTypes);
    }

    /** @dataProvider getFontAwesomeNameDataProvider */
    public function testGetFontAwesomeName(): void
    {
        $fontNames = InformationTypeEnum::getFontAwesomeName(1);

        Assert::assertSame('fa fa-fw fa-home', $fontNames);
    }

    public function testGetFontAwesomeNameWithIncorrectEnum(): void
    {
        $this->expectException(UnknownEnumException::class);
        $this->expectExceptionMessage('Unknown enum key: 3.');

        InformationTypeEnum::getFontAwesomeName(3);
    }

    public function getFontAwesomeNameDataProvider(): \Generator
    {
        yield 'info' => [0, 'fa fa-fw fa-info-circle'];
        yield 'home' => [1, 'fa fa-fw fa-home'];
    }
}
