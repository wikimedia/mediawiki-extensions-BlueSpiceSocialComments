<?php

/**
 * BSSociaEntityComment class for BSSocial
 *
 * add desc
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; version 3 of the License.
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
 * @copyright  Copyright (C) 2018 Hallo Welt! GmbH, All rights reserved.
 * @license    http://www.gnu.org/copyleft/gpl.html GPL-3.0-only
 */
namespace BlueSpice\Social\Comments\Entity;

use BlueSpice\Social\Entity\Text;
use BlueSpice\EntityConfig;
use BlueSpice\EntityFactory;

/**
 * Comment class for BSSocial extension
 * @package BlueSpiceSocial
 * @subpackage BSSocialMicroBlog
 */
class Comment extends Text {
	const TYPE = 'comment';

	/**
	 * Returns the instance - Should not be used directly. This is a workaround
	 * as all entity __construct methods are protected. Use mediawiki service
	 * 'BSEntityFactory' instead
	 * @param \stdClass $data
	 * @param \BlueSpice\EntityConfig $oConfig
	 * @param \BlueSpice\EntityFactory $entityFactory
	 * @return \static
	 */
	public static function newFromFactory( \stdClass $data, EntityConfig $oConfig, EntityFactory $entityFactory ) {
		$instance = new static( $data, $oConfig );
		//Dealing with currupted entities, whenever a proccess or - more likely
		//a human breaks stuff by deleting, moving, protecting... etc. source
		//titles
		if( $instance->get( static::ATTR_PARENT_ID ) < 1 ) {
			return null;
		}
		if( !$instance->getParent() ) {
			return null;
		}
		return $instance;
	}

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

	public function save(\User $oUser = null, $aOptions = array()) {
		if( !$this->getParent() || !$this->getParent()->exists() ) {
			return \Status::newFatal(
				'bs-socialcomments-entity-fatalstatus-save-emptyfield',
				$this->getVarMessage( static::ATTR_PARENT_ID )->plain()
			);
		}
		return parent::save( $oUser, $aOptions );
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
			strip_tags( $this->getParent()->getHeader()->parse() )
		]);
	}
}