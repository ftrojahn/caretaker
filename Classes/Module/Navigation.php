<?php

namespace Caretaker\Caretaker\Module;

use \TYPO3\CMS\Backend\Module\BaseScriptClass;

use \TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use \TYPO3\CMS\Core\Utility\GeneralUtility;

class Navigation extends BaseScriptClass
{
    public $pageinfo;

    public $node_repository;

    public $instance_repository;

    /**
     * @var \TYPO3\CMS\Core\Page\PageRenderer
     */
    public $pageRenderer;

    public function mainAction(
        \Psr\Http\Message\ServerRequestInterface $request,
        \Psr\Http\Message\ResponseInterface $response
    ) {
        global $BE_USER, $LANG, $BACK_PATH, $TCA_DESCR, $TCA, $CLIENT, $TYPO3_CONF_VARS;

        $PATH_TYPO3 = GeneralUtility::getIndpEnv('TYPO3_SITE_URL') . 'typo3/';

        if ($BE_USER->user['admin']) {
            // Draw the header.
            $this->doc = GeneralUtility::makeInstance('TYPO3\\CMS\\Backend\\Template\\DocumentTemplate');
            $this->doc->backPath = $BACK_PATH;

            $this->pageRenderer = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Page\PageRenderer::class);

            // Include Ext JS
            $this->pageRenderer->loadExtJS(true, true);
            $this->pageRenderer->enableExtJsDebug();
            $this->pageRenderer->addJsFile(ExtensionManagementUtility::extRelPath('caretaker') . 'res/js/tx.caretaker.js', 'text/javascript', false, false);
            $this->pageRenderer->addJsFile(ExtensionManagementUtility::extRelPath('caretaker') . 'res/js/tx.caretaker.NodeTree.js', 'text/javascript', false, false);

            //Add caretaker css
            $this->pageRenderer->addCssFile(ExtensionManagementUtility::extRelPath('caretaker') . 'res/css/tx.caretaker.nodetree.css', 'stylesheet', 'all', '', false);

            // storage Pid
            $confArray = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['caretaker']);
            $storagePid = (int)$confArray['storagePid'];

            $this->pageRenderer->addJsInlineCode('Caretaker_Nodetree',
                '
			Ext.state.Manager.setProvider(new Ext.state.CookieProvider());
			Ext.ns("tx.caretaker");
			Ext.onReady(function() {
				tx.caretaker.view = new Ext.Viewport({
					layout: "fit",
					items: {
						id: "cartaker-tree",
						xtype: "caretaker-nodetree",
						autoScroll: true,
						dataUrl: TYPO3.settings.ajaxUrls[\'tx_caretaker::treeloader\'],
						getModuleUrlUrl: TYPO3.settings.ajaxUrls[\'tx_caretaker::getModuleUrl\'],
						storagePid: ' . $storagePid . ',
						addUrl: "' . $PATH_TYPO3 . 'alt_doc.php?edit[###NODE_TYPE###][' . $storagePid . ']=new"
					}
				});

				tx_caretaker_updateTreeById = function( id ){
					tx_caretaker_tree = Ext.getCmp("cartaker-tree");
					tx_caretaker_tree.reloadTreePartial( id );
				}
			});
			');

            $this->content .= $this->doc->startPage($LANG->getLL('title'));
            $this->doc->form = '';
        } else {
            // If no access or if not admin

            $this->doc = GeneralUtility::makeInstance('TYPO3\CMS\Backend\Template\MediumDocumentTemplate');
            $this->doc->backPath = $BACK_PATH;

            $this->content .= $this->doc->startPage($LANG->getLL('title'));
            $this->content .= $this->doc->header($LANG->getLL('title'));
            $this->content .= $this->doc->spacer(5);
            $this->content .= $this->doc->spacer(10);
        }

        $this->content .= $this->doc->endPage();
        $response->getBody()->write($this->content);
        return $response;
    }
}
