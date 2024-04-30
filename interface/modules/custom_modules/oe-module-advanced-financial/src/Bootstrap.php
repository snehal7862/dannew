<?php

namespace Juggernaut\Module\AdvancedFinancial;


use OpenEMR\Common\Logging\SystemLogger;
use OpenEMR\Core\Kernel;
use OpenEMR\Menu\MenuEvent;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class Bootstrap
{
    const MODULE_INSTALLATION_PATH = "/interface/modules/custom_modules/";
    const MODULE_NAME = "oe-module-advanced-financial";
    /**
     * @var EventDispatcherInterface The object responsible for sending and subscribing to events through the OpenEMR system
     */
    private $eventDispatcher;
    private Kernel $kernel;

    public function __construct(EventDispatcher $dispatcher, Kernel $kernel)
    {
        //global $GLOBALS;

        if (empty($kernel)) {
            $kernel = new Kernel();
        }

        $this->eventDispatcher = $dispatcher;
        $this->kernel = $kernel;


        $this->moduleDirectoryName = basename(dirname(__DIR__));
        //$this->logger = new SystemLogger();

        // we inject our globals value.
        $this->globalsConfig = new GlobalConfig($GLOBALS);
        $this->logger = new SystemLogger();
    }

    public function subscribeToEvents()
    {
        $this->registerMenuItems();
    }

    public function registerMenuItems(): void
    {
        /**
         * @var EventDispatcherInterface $eventDispatcher
         * @var array $module
         * @global                       $eventDispatcher @see ModulesApplication::loadCustomModule
         * @global                       $module @see ModulesApplication::loadCustomModule
         */
        $this->eventDispatcher->addListener(MenuEvent::MENU_UPDATE, [$this, 'addAdvancedFinancialMenuItem']);
        //$this->eventDispatcher->addListener(MenuEvent::MENU_UPDATE, [$this, 'adminEarningsReportMenuItem']);
        //$this->eventDispatcher->addListener(MenuEvent::MENU_UPDATE, [$this, 'providerViewEarningsReportMenuItem']);
    }

    public function addAdvancedFinancialMenuItem(MenuEvent $event): MenuEvent
    {
        $menu = $event->getMenu();

        $menuItem = new \stdClass();
        $menuItem->requirement = 0;
        $menuItem->target = 'rep';
        $menuItem->menu_id = 'rep0';
        $menuItem->label = xlt("Advanced Financial Reports");
        // TODO: pull the install location into a constant into the codebase so if OpenEMR changes this location it
        // doesn't break any modules.
        $menuItem->url = "/interface/modules/custom_modules/oe-module-advanced-financial/public/index.php";
        $menuItem->children = [];

        /**
         * This defines the Access Control List properties that are required to use this module.
         * Several examples are provided
         */
        $menuItem->acl_req = ["admin", "super"];

        /**
         * If you want your menu item to allows be shown then leave this property blank.
         */
        $menuItem->global_req = [];

        foreach ($menu as $item) {
            if ($item->menu_id == 'repimg') {
                $item->children[] = $menuItem;
                break;
            }
        }

        $event->setMenu($menu);

        return $event;
    }

    public function adminEarningsReportMenuItem(MenuEvent $event): MenuEvent
    {
        $menu = $event->getMenu();

        $menuItem = new \stdClass();
        $menuItem->requirement = 0;
        $menuItem->target = 'rep';
        $menuItem->menu_id = 'rep0';
        $menuItem->label = xlt("Advanced Financial Reports");
        // TODO: pull the install location into a constant into the codebase so if OpenEMR changes this location it
        // doesn't break any modules.
        $menuItem->url = "/interface/modules/custom_modules/oe-module-advanced-financial/public/index.php";
        $menuItem->children = [];

        /**
         * This defines the Access Control List properties that are required to use this module.
         * Several examples are provided
         */
        $menuItem->acl_req = ["admin", "super"];

        /**
         * If you want your menu item to allows be shown then leave this property blank.
         */
        $menuItem->global_req = [];

        foreach ($menu as $item) {
            if ($item->menu_id == 'repimg') {
                $item->children[] = $menuItem;
                break;
            }
        }

        $event->setMenu($menu);

        return $event;
    }

    public function providerViewEarningsReportMenuItem(MenuEvent $event): MenuEvent
    {
        $menu = $event->getMenu();

        $menuItem = new \stdClass();
        $menuItem->requirement = 0;
        $menuItem->target = 'rep';
        $menuItem->menu_id = 'rep0';
        $menuItem->label = xlt("Providers Earnings Self");
        // TODO: pull the install location into a constant into the codebase so if OpenEMR changes this location it
        // doesn't break any modules.
        $menuItem->url = "/interface/modules/custom_modules/oe-module-payroll/public/reports/provider_earning_report.php";
        $menuItem->children = [];

        /**
         * This defines the Access Control List properties that are required to use this module.
         * Several examples are provided
         */
        $menuItem->acl_req = ["patients", "appt"];

        /**
         * If you want your menu item to allows be shown then leave this property blank.
         */
        $menuItem->global_req = [];

        foreach ($menu as $item) {
            if ($item->menu_id == 'repimg') {
                $item->children[] = $menuItem;
                break;
            }
        }

        $event->setMenu($menu);

        return $event;
    }

    private function getPublicPath()
    {
        return self::MODULE_INSTALLATION_PATH . ($this->moduleDirectoryName ?? '') . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR;
    }

    private function getAssetPath()
    {
        return $this->getPublicPath() . 'assets' . DIRECTORY_SEPARATOR;
    }
}
