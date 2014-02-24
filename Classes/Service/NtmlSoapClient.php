<?php 
namespace BLSV\Navsoapinterface\Service;
/***************************************************************
 *  Copyright notice
 *
 * Copyright (c) 2008 Invest-In-France Agency http://www.invest-in-france.org
 *
 * Author : Thomas Rabaix 
 *
 * Permission to use, copy, modify, and distribute this software for any
 * purpose with or without fee is hereby granted, provided that the above
 * copyright notice and this permission notice appear in all copies.
 *
 * THE SOFTWARE IS PROVIDED "AS IS" AND THE AUTHOR DISCLAIMS ALL WARRANTIES
 * WITH REGARD TO THIS SOFTWARE INCLUDING ALL IMPLIED WARRANTIES OF
 * MERCHANTABILITY AND FITNESS. IN NO EVENT SHALL THE AUTHOR BE LIABLE FOR
 * ANY SPECIAL, DIRECT, INDIRECT, OR CONSEQUENTIAL DAMAGES OR ANY DAMAGES
 * WHATSOEVER RESULTING FROM LOSS OF USE, DATA OR PROFITS, WHETHER IN AN
 * ACTION OF CONTRACT, NEGLIGENCE OR OTHER TORTIOUS ACTION, ARISING OUT OF
 * OR IN CONNECTION WITH THE USE OR PERFORMANCE OF THIS SOFTWARE.
 *
 *
 *
 * This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
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
 *  
 ***************************************************************/

class NtmlSoapClient extends \SoapClient {
	
	/**
	 * 
	 * @param mixed $wsdl
	 * @param array $options
	 * @throws \Exception
	 */
	public function __construct($wsdl, $options = array()) {
		if (empty($options['user']) || empty($options['password'])) throw new \TYPO3\CMS\Extbase\Configuration\Exception('user and password required for NTLM authentication!',13926543421);
		$this->user = $options['user'];
		$this->password = $options['password'];
		parent::__construct($wsdl, $options);
	}
	
	/**
	 * 
	 * @param string $request
	 * @param string $location
	 * @param string $action
	 * @param string $version
	 * @return void
	 */
  function __doRequest($request, $location, $action, $version) {
      $headers = array(
      'Method: POST',
      'Connection: Keep-Alive',
      'User-Agent: PHP-SOAP-CURL',
      'Content-Type: text/xml; charset=utf-8',
      'SOAPAction: "'.$action.'"',
    );

    $this->__last_request_headers = $headers;
    $ch = curl_init($location);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POST, true );
    curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_NTLM);
    curl_setopt($ch, CURLOPT_USERPWD, $this->user.':'.$this->password);
    $response = curl_exec($ch);
    
    return $response;
  }
  
  /**
   * 
   * @return string
   */
  function __getLastRequestHeaders() {
    return implode("\n", $this->__last_request_headers)."\n";
  }
}

