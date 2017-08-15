<?php

use TYPO3\CMS\Extbase\Mvc\Controller\ControllerInterface;

class Tx_Caretaker_Controller_OverviewController extends \Caretaker\Caretaker\Module\Overview implements ControllerInterface {

    /**
     * Checks if the current request type is supported by the controller.
     *
     * @param \TYPO3\CMS\Extbase\Mvc\RequestInterface $request The current request
     * @return bool TRUE if this request type is supported, otherwise FALSE
     * @api
     */
    public function canProcessRequest(\TYPO3\CMS\Extbase\Mvc\RequestInterface $request)
    {
        // TODO: Implement canProcessRequest() method.
    }

    /**
     * Processes a general request. The result can be returned by altering the given response.
     *
     * @param \TYPO3\CMS\Extbase\Mvc\RequestInterface $request The request object
     * @param \TYPO3\CMS\Extbase\Mvc\ResponseInterface $response The response, modified by the controller
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException if the controller doesn't support the current request type
     * @api
     */
    public function processRequest(\TYPO3\CMS\Extbase\Mvc\RequestInterface $request, \TYPO3\CMS\Extbase\Mvc\ResponseInterface $response)
    {
        // TODO: Implement processRequest() method.
    }
}
