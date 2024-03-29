<?php

namespace BlueSpice\Social\Comments\Notification;

use BlueSpice\Social\Entity;
use BlueSpice\Social\Notifications\SocialTextNotification;
use MediaWiki\MediaWikiServices;
use Message;
use Title;
use User;

class SocialCommentsNotification extends SocialTextNotification {
	protected $parentEntityOwner;
	protected $parentEntityOwnerRealname;
	protected $parentEntity;

	/**
	 *
	 * @return array
	 */
	public function getParams() {
		$params = parent::getParams();

		$params['primary-link-label'] = Message::newFromKey(
			'bs-social-notification-comment-primary-link-label'
		)->plain();

		$this->getParentEntityInfo();

		if ( $this->parentEntity ) {
			$topicsSP = MediaWikiServices::getInstance()->getSpecialPageFactory()->getPage( 'Topics' );
			$params['parentownerrealname'] = $this->parentEntityOwnerRealname;
			$params['secondary-links'] = [
				'parentowner' => [
					'url' => $this->parentEntityOwner->getUserPage()->getFullURL(),
					'label-params' => [ $this->parentEntityOwnerRealname ]
				],
				'parententity' => [
					'url' => $topicsSP->getPageTitle( $this->parentEntity->get( Entity::ATTR_ID ) )->getFullURL(),
				]
			];
		}

		return $params;
	}

	/**
	 *
	 * @return Title
	 */
	protected function getWatchedTitle() {
		$parent = $this->entity->getParent();
		return $parent->getTitle();
	}

	/**
	 *
	 * @return int[]
	 */
	protected function getUserIdsToSkip() {
		$usersToSkip = parent::getUserIdsToSkip();
		if ( $this->parentEntityOwner instanceof User ) {
			$usersToSkip[] = $this->parentEntityOwner->getId();
		}

		return $usersToSkip;
	}

	/**
	 *
	 * @return \Title|null
	 */
	public function getTitle() {
		$title = $this->entity->getTitle();
		if ( $title instanceof \Title && $title->exists() ) {
			$topicsSP = MediaWikiServices::getInstance()->getSpecialPageFactory()->getPage( 'Topics' );
			$title = $topicsSP->getPageTitle( $this->entity->get( Entity::ATTR_ID ) );
			return $title;
		}
		return null;
	}

	/**
	 *
	 * @return void
	 */
	protected function getParentEntityInfo() {
		if ( $this->entity->hasParent() == false ) {
			return;
		}

		$this->parentEntity = $this->entity->getParent();

		$this->parentEntityOwner = $this->parentEntity->getOwner();

		if ( $this->parentEntityOwner instanceof User ) {
			$this->parentEntityOwnerRealname = MediaWikiServices::getInstance()
				->getService( 'BSUtilityFactory' )
				->getUserHelper( $this->parentEntityOwner )
				->getDisplayName();
		}
	}
}
