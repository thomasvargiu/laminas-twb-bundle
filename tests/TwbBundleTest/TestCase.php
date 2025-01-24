<?php
declare(strict_types=1);

namespace TwbBundleTest;
use PHPUnit\Framework\Constraint\IsEqual;
use PHPUnit\Framework\Constraint\LogicalOr;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    public static function getExpectedAlternative(string $expected): string
    {
        $expected2 = str_replace('disabled="disabled"', 'disabled', $expected);
        $expected2 = str_replace('required="required"', 'required', $expected2);
        $expected2 = str_replace('multiple="multiple"', 'multiple', $expected2);
        $expected2 = str_replace('checked="checked"', 'checked', $expected2);

        return $expected2;
    }

    public static function getExpectedAlternatives(string $expected): array
    {
        return [$expected, self::getExpectedAlternative($expected)];
    }

    /**
     * @param string $expectedFile
     * @param string $actual
     * @param string $message
     */
    public static function twbAssertStringEquals(string $expected, string $actual, string $message = ''): void
    {
        $constraint = LogicalOr::fromConstraints(
            ...array_map(static function ($a) { return new IsEqual($a); }, self::getExpectedAlternatives($expected))
        );

        static::assertThat($actual, $constraint, $message);
    }

    /**
     * @param string $expectedFile
     * @param string $actualString
     * @param string $message
     */
    public static function twbAssertStringEqualsFile(string $expectedFile, string $actualString, string $message = '')
    {
        static::assertFileExists($expectedFile, $message);

        $content = file_get_contents($expectedFile);

        static::twbAssertStringEquals($content, $actualString, $message);
    }
}
