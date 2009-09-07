<?php
/**
 * This program is free software: you can redistribute it and/or modify it under the terms of
 * the GNU General Public License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with this program.
 * If not, see <http://www.gnu.org/licenses/>.
 *
 * WowArmadaException Class
 *
 * Copyright (C) <2009>  <codejam>
 */
class WowArmadaException extends Exception {

	/**
	 * Current version of the Wow Armada classes.
	 * @access      protected
	 * @var         string      Contains the current class version.
	 */
	protected static $wowArmadaVersion = "0.2";
	
	/**
	 * Current state of the Wow Armada class. Allowed values are alpha, beta,
	 * and release.
	 * @access      protected
	 * @var         string      Contains the current versions' state.
	 */
	protected static $wowArmadaVersion_state = "alpha";
	  	  
		// Redefine the exception so message isn't optional
	public function __construct($message, $code = 0) {
	    // make sure everything is assigned properly
	    $customMessage = 'Wow Armada ' . self::$wowArmadaVersion . ' - ' . self::$wowArmadaVersion_state . ':' . $message;
	    parent::__construct($customMessage, $code);
	}
	
	// custom string representation of object
	public function __toString() {
	    return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
	}
}
?>