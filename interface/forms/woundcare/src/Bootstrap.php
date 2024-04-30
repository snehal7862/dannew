<?php

/**
 * This class bootstraps the form and connects
 */

namespace WoundCare;

require_once __DIR__ . "/../vendor/autoload.php";

use OpenEMR\Common\Twig\TwigContainer;
use OpenEMR\Core\Kernel;
use OpenEMR\Events\Globals\GlobalsInitializedEvent;
use OpenEMR\Menu\MenuEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class Bootstrap
{
    const FORM_INSTALLATION_PATH = 'interface/forms/woundcare';
    const FORM_NAME = 'Wound Care';

    /**
     * @var \GlobalConfig Holds our module global configuration values that can be used throughout the module.
     */
    private \GlobalConfig $globalConfig;

    /**
     * @var \Twig\Environment The twig rendering environment
     */
    private \Twig\Environment $twig;

    public function __construct(?Kernal $kernal = null)
    {
        global $GLOBALS;

        if (empty($kernal)) {
            $kernal = new Kernel();
        }

        $twig = new TwigContainer($this->getTemplatePath(), $kernal);
        $twigEnv = $twig->getTwig();
        $this->twig = $twigEnv;
    }

    public function twigEnv(): \Twig\Environment
    {
        return $this->twig;
    }
    /**
     * @return GlobalConfig
     */
    public function getGlobalConfig()
    {
        return $this->globalsConfig;
    }

    public function addGlobalSettings(): void
    {
        $this->eventDispatcher->addListener(GlobalsInitializedEvent::EVENT_HANDLE, [$this, 'addGlobalSettingsSection']);
    }

    public function registerMenuItems(): void
    {
        if ($this->getGlobalConfig()->getGlobalSetting(GlobalConfig::CONFIG_ENABLE_MENU)) {
            /**
             * @var EventDispatcherInterface $eventDispatcher
             * @var array $module
             * @global                       $eventDispatcher @see ModulesApplication::loadCustomModule
             * @global                       $module @see ModulesApplication::loadCustomModule
             */
            $this->eventDispatcher->addListener(MenuEvent::MENU_UPDATE, [$this, 'addCustomModuleMenuItem']);
        }
    }

    /**
     * @return string
     */
    public function getTemplatePath(): string
    {
        return \dirname(__DIR__) . DIRECTORY_SEPARATOR . "views" . DIRECTORY_SEPARATOR;
    }

    public function content(): array
    {
        $saveLocation = "../../forms/woundcare/save.php";
        return [
            'p_heading' => 'PATIENT INFORMATION',
            'm_heading' => 'MEDICAL INFORMATION',
            'action' => $saveLocation
        ];
    }
}
