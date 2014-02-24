<?php
namespace BLSV\Navsoapinterface\Controller;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Berti Golf <berti.golf@blsv.de>, BLSV
 *  
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 *
 *
 * @package navsoapinterface
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class XmlController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * xmlRepository
	 *
	 * @var \BLSV\Navsoapinterface\Domain\Repository\XmlRepository
	 * @inject
	 */
	protected $xmlRepository;

	/**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
		$url = 'http://durin.blsv.de:7047/DynamicsNAV/WS/Codeunit/WSBLSV';
		
		// we unregister the current HTTP wrapper
		stream_wrapper_unregister('http');
		
		// we register the new HTTP wrapper
		stream_wrapper_register('http', '\BLSV\Navsoapinterface\Service\NtmlStream') or ("Failed to register protocol");
		
		// so now all request to a http page will be done by MyServiceProviderNTLMStream.
		// ok now, let's request the wsdl file
		// if everything works fine, you should see the content of the wsdl file
		
		$options['user'] = 'golfb';
		$options['password'] = 'volley2010%';
		$options['location'] = $url;
		try {
			//$client = new \BLSV\Navsoapinterface\Service\NtmlSoapClient('/www/qualinet2012.blsv.de/htdocs/typo3conf/ext/navsoapinterface/Resources/Private/Templates/Xml/wsdl.xml', $options);
			
			$client = new \BLSV\Navsoapinterface\Service\NtmlSoapClient('http://durin.blsv.de:7047/DynamicsNAV/WS/Codeunit/WSBLSV', $options);
				
		} catch (Exception  $e) {
			echo 'Fehler: ' .  $e->faultcode;
		}
		
		
		
		// should display your reply
		 $client->GetCustomer();
		
		// restore the original http protocole
		stream_wrapper_restore('http');		
	}

	/**
	 * action show
	 *
	 * @param \BLSV\Navsoapinterface\Domain\Model\Xml $xml
	 * @return void
	 */
	public function showAction(\BLSV\Navsoapinterface\Domain\Model\Xml $xml) {
		$this->view->assign('xml', $xml);
	}

	/**
	 * action new
	 *
	 * @param \BLSV\Navsoapinterface\Domain\Model\Xml $newXml
	 * @dontvalidate $newXml
	 * @return void
	 */
	public function newAction(\BLSV\Navsoapinterface\Domain\Model\Xml $newXml = NULL) {
		$this->view->assign('newXml', $newXml);
	}

	/**
	 * action create
	 *
	 * @param \BLSV\Navsoapinterface\Domain\Model\Xml $newXml
	 * @return void
	 */
	public function createAction(\BLSV\Navsoapinterface\Domain\Model\Xml $newXml) {
		$this->xmlRepository->add($newXml);
		$this->flashMessageContainer->add('Your new Xml was created.');
		$this->redirect('list');
	}

	/**
	 * action edit
	 *
	 * @param \BLSV\Navsoapinterface\Domain\Model\Xml $xml
	 * @return void
	 */
	public function editAction(\BLSV\Navsoapinterface\Domain\Model\Xml $xml) {
		$this->view->assign('xml', $xml);
	}

	/**
	 * action update
	 *
	 * @param \BLSV\Navsoapinterface\Domain\Model\Xml $xml
	 * @return void
	 */
	public function updateAction(\BLSV\Navsoapinterface\Domain\Model\Xml $xml) {
		$this->xmlRepository->update($xml);
		$this->flashMessageContainer->add('Your Xml was updated.');
		$this->redirect('list');
	}

	/**
	 * action get
	 *
	 * @return void
	 */
	public function getAction() {

	}

	/**
	 * action
	 *
	 * @return void
	 */
	public function Action() {

	}

}
?>