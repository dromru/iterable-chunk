<?php

declare(strict_types=1);

use PHP_CodeSniffer\Standards\PSR12\Sniffs\ControlStructures\BooleanOperatorPlacementSniff;
use PHP_CodeSniffer\Standards\PSR12\Sniffs\ControlStructures\ControlStructureSpacingSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\ControlStructures\ControlSignatureSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\Files\LineLengthSniff;
use PhpCsFixer\Fixer\ArrayNotation\NoTrailingCommaInSinglelineArrayFixer;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\CodingStandard\Fixer\LineLength\LineLengthFixer;
use Symplify\CodingStandard\Sniffs\CleanCode\ForbiddenReferenceSniff;
use Symplify\CodingStandard\Sniffs\CleanCode\ForbiddenStaticFunctionSniff;
use Symplify\EasyCodingStandard\ValueObject\Option;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;
use SlevomatCodingStandard\Sniffs\Variables\UnusedVariableSniff;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(NoTrailingCommaInSinglelineArrayFixer::class);

    $services->set(LineLengthFixer::class);

    $services->set(ControlStructureSpacingSniff::class);

    $services->set(BooleanOperatorPlacementSniff::class);

    $services->set(ControlSignatureSniff::class);

    $services->set(LineLengthSniff::class)
        ->property('absoluteLineLimit', 120);

    $services->set(ForbiddenStaticFunctionSniff::class);

    $services->set(ForbiddenReferenceSniff::class);

    $parameters = $containerConfigurator->parameters();

    $parameters->set(Option::SKIP, [UnusedVariableSniff::class => null]);

    $parameters->set(Option::SETS, [SetList::CLEAN_CODE, SetList::PSR_12]);
};
