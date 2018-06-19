<?php

/**
 * BSSociaEntityComment class for BSSocial
 *
 * add desc
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 *
 * This file is part of BlueSpice MediaWiki
 * For further information visit http://bluespice.com
 *
 * @author     Patric Wirth <wirth@hallowelt.com>
 * @package    BlueSpiceSocial
 * @subpackage BSSocialMicroBlog
 * @copyright  Copyright (C) 2017 Hallo Welt! GmbH, All rights reserved.
 * @license    http://www.gnu.org/copyleft/gpl.html GNU Public License v2 or later
 */
namespace BlueSpice\Social\Comments\Entity;
use BlueSpice\Social\Entity\Text;
/**
 * Comment class for BSSocial extension
 * @package BlueSpiceSocial
 * @subpackage BSSocialMicroBlog
 */
class Comment extends Text {
	const TYPE = 'comment';

	public function getActions( array $aActions = array(), \User $oUser = null ) {
		$aActions = parent::getActions( $aActions, $oUser );
		if( in_array( 'create', $aActions ) ) {
			if( !$this->hasParent() ) {
				//Comments must have a parrent
				unset( $aActions[ 'create'] );
			}
		}
		return $aActions;
	}

	/**
	 * Returns the Message object for the entity header
	 * @param Message $msg
	 * @return Message
	 */
	public function getHeader( $msg = null ) {
		$msg = parent::getHeader( $msg );
		if( !$this->exists() ) {
			return $msg;
		}
		return $msg->params( [
			$this->getParent()->getTitle()->getFullText(),
			$this->getParent()->getHeader()
		]);
	}
}