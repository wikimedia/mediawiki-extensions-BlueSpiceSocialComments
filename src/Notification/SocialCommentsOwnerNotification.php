<?php

namespace BlueSpice\Social\Comments\Notification;

use BlueSpice\Social\Comments\Notification\SocialCommentsNotification;

class SocialCommentsOwnerNotification extends SocialCommentsNotification {
	public function getKey() {
		return $this->key . '-owner-' . $this->action;
	}

	/**
	 * Send this notification only to parent user
	 */
	protected function getUsersWatching() {
		if( $this->parentEntityOwner instanceof \User ) {
			return [$this->parentEntityOwner->getId() => $this->parentEntityOwner];
		}
	}
}