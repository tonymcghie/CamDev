<?php

require_once 'Behat/vendor/autoload.php';

use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context {

    private $session;
    private $startTime;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct() {
        $driver = new \Behat\Mink\Driver\Selenium2Driver();
        $this->session = new \Behat\Mink\Session($driver);

        $this->session->start();
        $this->session->maximizeWindow();
        $this->startTime = time();
    }

    /**
     * Goes back to a blank workspace
     *
     * @When /^I go to the homepage$/
     */
    public function goToHomePage() {
        try {
            $this->session->visit('http://192.168.20.20/CamDev');
        } catch (Exception $e) {
            throw new BehatException($e,
                $this->session,
                $this->startTime,
                'iShouldSee');
        }
    }

    /**
     * Waits for x seconds
     *
     * @When /^I wait for "([^"]*)" seconds$/
     * @param int $time
     */
    public function iWaitSeconds($time) {
        try {
            $this->session->wait($time * 1000);
        } catch (Exception $e) {
            throw new BehatException($e,
                $this->session,
                $this->startTime,
                'iShouldSee');
        }
    }

    /**
     * Checks the currrent url
     *
     * @Then /^I should be on page "([^"]*)"$/
     * @param string $url
     */
    public function iShouldBeOnPage($url) {
        if ($this->session->getCurrentUrl() != $url) {
            throw new Exception("the current url did not match '{$this->session->getCurrentUrl()}'");
        }
    }

    /**
     * Text should be on the page
     *
     * @Then /^I should see "([^"]*)"$/
     * @param string $text
     * @throws Exception
     */
    public function iShouldSee($text) {
        $page = $this->session->getPage();
        if (!$page->hasContent($text)) {
            throw new BehatException("the text '$text' was not found on the page",
                $this->session,
                $this->startTime,
                'iShouldSee');
        }
    }

    /**
     * Press a button
     *
     * @When /^I Press the button "([^"]*)"$/
     * @param string $identifier can be id|name|title|alt|value
     */
    public function iPressButton($identifier) {
        try {
            $this->session->getPage()->pressButton($identifier);
        } catch (Exception $e) {
            throw new BehatException($e,
                $this->session,
                $this->startTime,
                'iShouldSee');
        }
    }

    /**
     * Click a link
     *
     * @When /^I follow the link "([^"]*)"$/
     * @param string $identifier id title text or alt of image
     */
    public function iFollowLink($identifier) {
        try {
            $this->session->getPage()->clickLink($identifier);
        } catch (Exception $e) {
            throw new BehatException($e,
                $this->session,
                $this->startTime,
                'iShouldSee');
        }
    }
}
