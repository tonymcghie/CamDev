<?php

/**
 * Created by PhpStorm.
 * User: mgoo
 * Date: 2/12/17
 * Time: 10:04 AM
 */
class BehatException extends Exception {

    /**
     * BehatException constructor.
     * @param Exception|string $cause
     * @param \Behat\Mink\Session $session
     * @param int $time
     */
    public function __construct($cause, $session, $time, $step) {
        if (is_string($cause)) {
            $this->message = $cause;
        } else {
            $this->message = $cause->getMessage();
        }

        if (!file_exists("BehatFailures/$time")) {
            mkdir("BehatFailures/$time", 0777, true);
        }
        $screenshotFile = fopen("BehatFailures/$time/$step.png", "w");
        fwrite($screenshotFile, $session->getScreenshot());
        $htmlFile = fopen("BehatFailures/$time/$step.html", "w");
        fwrite($htmlFile , $session->getPage()->getOuterHtml());
    }

}