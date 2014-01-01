<?php

namespace Acts\CamdramSecurityBundle\Features\Context;

use Acts\CamdramBackendBundle\DataFixtures\ORM\AccessControlEntryFixtures;
use Acts\CamdramBackendBundle\DataFixtures\ORM\ShowFixtures;
use Acts\CamdramBackendBundle\DataFixtures\ORM\UserFixtures;
use Acts\CamdramBackendBundle\Features\Context\SymfonyContext;
use Acts\CamdramBackendBundle\Features\Context\UserContext;
use Behat\Behat\Context\BehatContext;
use Behat\Behat\Event\ScenarioEvent;
use Behat\MinkExtension\Context\MinkContext;
use Symfony\Component\HttpKernel\KernelInterface;
use Behat\Symfony2Extension\Context\KernelAwareInterface;

use Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;

//
// Require 3rd-party libraries here:
//
//   require_once 'PHPUnit/Autoload.php';
//   require_once 'PHPUnit/Framework/Assert/Functions.php';
//

/**
 * Feature context.
 */
class FeatureContext extends BehatContext
{
    public function __construct(array $params) {
        $this->useContext('mink', new MinkContext());
        $this->useContext('users', new UserContext());
        $this->useContext('symfony', new SymfonyContext());
    }

    /**
     * @return \Behat\MinkExtension\Context\MinkContext
     */
    private function getMinkContext()
    {
        return $this->getMainContext()->getSubcontext('mink');
    }

}
