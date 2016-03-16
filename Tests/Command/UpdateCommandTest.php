<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\Tests\Command;

use OpenClassrooms\Bundle\OneSkyBundle\Command\UpdateCommand;
use OpenClassrooms\Bundle\OneSkyBundle\Tests\Doubles\Services\TranslationServiceMock;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class UpdateCommandTest extends \PHPUnit_Framework_TestCase
{
    use CommandTestCase;

    /**
     * @var CommandTester
     */
    private $commandTester;

    /**
     * @test
     */
    public function without_locale_execute()
    {
        $this->commandTester->execute(['command' => UpdateCommand::COMMAND_NAME]);
        $this->assertEquals([[realpath(__DIR__.'/../../'.self::$filePaths)]], TranslationServiceMock::$pulledFilePaths);
        $this->assertEquals([[realpath(__DIR__.'/../../'.self::$filePaths)]], TranslationServiceMock::$pushedFilePaths);
    }

    /**
     * @test
     */
    public function with_locales_execute()
    {
        $this->commandTester->execute(['command' => UpdateCommand::COMMAND_NAME, 'locales' => ['es']]);
        $this->assertEquals([[realpath(__DIR__.'/../../'.self::$filePaths)]], TranslationServiceMock::$pulledFilePaths);
        $this->assertEquals([[realpath(__DIR__.'/../../'.self::$filePaths)]], TranslationServiceMock::$pushedFilePaths);
        $this->assertEquals([['es']], TranslationServiceMock::$locales);
    }

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        $command = new UpdateCommand();
        $command->setContainer($this->getContainer());

        $application = new Application();
        $application->add($command);

        $this->commandTester = new CommandTester($application->find($command->getName()));
    }
}
