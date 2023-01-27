<?php
/**
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
 *
 * @file
 */

namespace MediaWiki\Extension\CookieToBodyClass;

use MediaWiki\Hook\BeforePageDisplayHook;
use OutputPage;
use Skin;

class Hooks implements BeforePageDisplayHook {

	/**
	 * @see https://www.mediawiki.org/wiki/Manual:Hooks/BeforePageDisplay
	 * @param OutputPage $out
	 * @param Skin $skin
	 */
	public function onBeforePageDisplay( $out, $skin ): void {
		$prefix = 'ctbc';
		
		$cookieClasses = array();
		foreach ( array_keys( $_COOKIE ) as $cookieName ) {
			if( strpos( $cookieName, $prefix .'_' ) === 0 ) {
				$cookieValue = $_COOKIE[ $cookieName ];
				
				if( preg_match( '/^-?[_a-zA-Z]+[_a-zA-Z0-9-]$/', $cookieValue ) !== 1 ) {
					array_push( $cookieClasses, $cookieName . '_' . $prefix . '-error_cookie-value-not-css-compatible' );
					continue;
				}
			
				array_push( $cookieClasses, $cookieName . '_' . $cookieValue );
			}
		}

		$out->addBodyClasses( $cookieClasses );
	}

}
