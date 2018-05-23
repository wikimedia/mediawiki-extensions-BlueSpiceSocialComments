<?php

namespace BlueSpice\Social\Comments\Notification;

use BlueSpice\Social\Notifications\SocialTextNotification;

class SocialCommentsNotification extends SocialTextNotification {
	protected $parentEntityOwner;
	protected $parentEntityOwnerRealname;
	protected $parentEntity;

	public function getParams() {
		$params = parent::getParams();

		$params['primary-link-label'] = wfMessage( 'bs-social-notification-comment-primary-link-label' )->plain();

		$this->getParentEntityInfo();

		if( $this->parentEntity ) {
			$params['parentownerrealname'] = $this->parentEntityOwnerRealname;
			$params['secondary-links'] = [
				'parentowner' => [
					'url' => $this->parentEntityOwner->getUserPage()->getFullURL(),
					'label-params' => [$this->parentEntityOwnerRealname]
				],
				'parententity' => [
					'url' => $this->parentEntity->getTitle()->getFullURL()
				]
			];
		}

		return $params;
	}

	protected function getUsersWatching() {
		$users = [];

		if( $this->entity->hasParent() == false ) {
			return $users;
		}

		$parent = $this->entity->getParent();
		$title = $parent->getTitle();
		if( !$title instanceof \Title || !$title->exists() ) {
			return $users;
		}

		//Is there a better way to retrieve users watching the title
		$res = wfGetDB( DB_SLAVE )->select(
			'watchlist',
			'wl_user',
			[
				'wl_namespace' => $title->getNamespace(),
				'wl_title' => $title->getText()
			],
			__METHOD__
		);

		foreach( $res as $row ) {
			$user = \User::newFromId( $row->wl_user );
			if( $user instanceof \User ) {
				if( $user->getId() == $this->user->getId() ) {
					//Do not notifier performer
					continue;
				}
				$users[$user->getId()] = $user;
			}
		}

		return $users;
	}

	protected function getParentEntityInfo() {
		if( $this->entity->hasParent() == false ) {
			return;
		}

		$this->parentEntity = $this->entity->getParent();

		$this->parentEntityOwner = $this->parentEntity ->getOwner();

		if( $this->parentEntityOwner instanceof \User ) {
			$this->parentEntityOwnerRealname = \BlueSpice\Services::getInstance()->getBSUtilityFactory()
				->getUserHelper( $parentOwner )->getDisplayName();
		}
	}
}