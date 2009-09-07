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
 * WowArmadaExceptionHandler Class
 *
 * Most of this class is taken from the remakable phpArmory project:
 *------------------------------------------------------------------------------------------------
 * phpArmory is an embeddable PHP5 class, which allow you to fetch XML data
 * from the World of Warcraft armory in order to display arena teams,
 * characters, guilds, and items on a web page.
 * @author Daniel S. Reichenbach <daniel.s.reichenbach@mac.com>
 * @copyright Copyright (c) 2008, Daniel S. Reichenbach
 * @license http://www.opensource.org/licenses/gpl-3.0.html GNU General Public License version 3
 * @link https://github.com/marenkay/phparmory/tree
 * @package phpArmory
 * @version 0.4.2
 *------------------------------------------------------------------------------------------------
 *
 * Copyright (C) <2009>  <codejam>
 */

class WowArmadaExceptionHandler {

    /**
     * Current version of the Wow Armada classes.
     * @access      protected
     * @var         string      Contains the current class version.
     */
    protected static $version = "0.2";

    /**
     * Current state of the Wow Armada class. Allowed values are alpha, beta,
     * and release.
     * @access      protected
     * @var         string      Contains the current versions' state.
     */
    protected static $version_state = "alpha";
	
    
    
   /**
     * Raise a PHP error.
     * @access      public
     * @param       string       $userError              The error string to output.
     */
    public static function triggerError ($userError = NULL) {
        if (is_string($userError)) {
            trigger_error("Wow Armada " . self::$version . " - " . self::$version_state . ": " . $userError, E_USER_ERROR);
        }
    }

    /**
     * Raise a PHP warning if the class is used from the command line.
     * @access      public
     * @param       string       $userWarning            The warning string to output.
     */
    public static function triggerWarning ($userWarning = NULL) {
        if (is_string($userWarning)) {
            $sapi_type = substr(php_sapi_name(), 0, 3);
            if ($sapi_type == 'cli') {
                trigger_error("Wow Armada " . self::$version . " - " . self::$version_state . ": " . $userWarning, E_USER_WARNING);
            }
        }
    }

    /**
     * Raise a PHP notice if the class is used from the command line.
     * @access      public
     * @param       string       $userNotice             The notice string to output.
     */
    public static function triggerNotice ($userNotice = NULL) {
        if (is_string($userNotice)) {
            $sapi_type = substr(php_sapi_name(), 0, 3);
            if ($sapi_type == 'cli') {
                trigger_error("Wow Armada " . self::$version . " - " . self::$version_state . ": " . $userNotice, E_USER_NOTICE);
            }
        }
    }
    
    /**
     * Build an Exception class that contains a message build with version information
     * @access      public
     * @param       string       $exceptionMessage             The exception message string to output.
     */
    public static function createExceptionMessage ($exceptionMessage = NULL) {
	    $result = "";
        $sapi_type = substr(php_sapi_name(), 0, 3);
        if ($sapi_type == 'cli') {
	        if (is_string($exceptionMessage)) {
				$result = "Wow Armada " . self::$version . " - " . self::$version_state . ": " . $exceptionMessage;
	         } else {
		        $result = "Wow Armada " . self::$version . " - " . self::$version_state;
	        }
        }
		return $result;
    }

    
}

?>
