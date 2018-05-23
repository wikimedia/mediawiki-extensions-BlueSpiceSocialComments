<?php

/**
 * SocialEntityCommentConfig class for BSSocial
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
 * @subpackage BSSocial
 * @copyright  Copyright (C) 2017 Hallo Welt! GmbH, All rights reserved.
 * @license    http://www.gnu.org/copyleft/gpl.html GNU Public License v2 or later
 * @filesource
 */
namespace BlueSpice\Social\Comments\EntityConfig;
use BlueSpice\Social\EntityConfig\Text;

/**
 * Comment class for BSSocial extension
 * @package BlueSpiceSocial
 * @subpackage BSSocial
 */
class Comment extends Text {
	public function addGetterDefaults() {
		return array();
	}
	protected function get_EntityClass() {
		return "\\BlueSpice\\Social\\Comments\\Entity\\Comment";
	}
	protected function get_ModuleStyles() {
		return array_merge( parent::get_ModuleStyles(), [
			'ext.bluespice.social.comments.styles',
		]);
	}
	protected function get_ModuleScripts() {
		return array_merge( parent::get_ModuleScripts(), [
			'ext.bluespice.social.entity.comment',
		]);
	}
	protected function get_HeaderMessageKeyCreateNew() {
		return 'bs-social-entitycomment-header-create';
	}
	protected function get_TypeMessageKey() {
		return 'bs-socialcomments-type';
	}
	protected function get_IsWatchable() {
		return false;
	}
	protected function get_IsSpawnable() {
		return false;
	}
	protected function get_IsTagable() {
		return false;
	}

	protected function get_NotificationObjectClass() {
		return \BlueSpice\Social\Comments\Notification\SocialCommentsNotification::class;
	}

	protected function get_NotificationTypePrefix() {
		return 'bs-social-comment';
	}
}