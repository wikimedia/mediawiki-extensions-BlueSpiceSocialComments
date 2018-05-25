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

	protected function getWatchedTitle() {
		$parent = $this->entity->getParent();
		return $parent->getTitle();
	}

	protected function getUserIdsToSkip() {
		$usersToSkip = parent::getUserIdsToSkip();
		if( $this->parentEntityOwner instanceof \User ) {
			$usersToSkip[] = $this->parentEntityOwner->getId();
		}

		return $usersToSkip;
	}

	protected function getParentEntityInfo() {
		if( $this->entity->hasParent() == false ) {
			return;
		}

		$this->parentEntity = $this->entity->getParent();

		$this->parentEntityOwner = $this->parentEntity ->getOwner();

		if( $this->parentEntityOwner instanceof \User ) {
			$this->parentEntityOwnerRealname = \BlueSpice\Services::getInstance()->getBSUtilityFactory()
				->getUserHelper( $this->parentEntityOwner )->getDisplayName();
		}
	}
}