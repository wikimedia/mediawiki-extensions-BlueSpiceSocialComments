<?php

namespace BlueSpice\Social\Comments\Event;

use MediaWiki\User\UserIdentity;
use Message;
use MWStake\MediaWiki\Component\Events\Delivery\IChannel;
use MWStake\MediaWiki\Component\Events\EventLink;

class SocialCommentForUserEvent extends SocialCommentEvent {

	/**
	 * @inheritDoc
	 */
	public function getLinks( IChannel $forChannel ): array {
		return [
			new EventLink(
				$this->getLinkTargetTitle()->getFullURL(),
				Message::newFromKey( 'bs-social-notification-comment-primary-link-label' )
			)
		];
	}

	/**
	 * @return Message
	 */
	public function getKeyMessage(): Message {
		return Message::newFromKey( "bs-social-comment-for-user-event-$this->action-desc" );
	}

	/**
	 * @inheritDoc
	 */
	public function getMessage( IChannel $forChannel ): Message {
		return Message::newFromKey( "bs-social-comment-for-user-event-$this->action" )
			->params( $this->getAgent()->getName() );
	}

	/**
	 * @return array|UserIdentity[]|null
	 */
	public function getPresetSubscribers(): ?array {
		$related = $this->doGetRelevantTitle();
		if ( $related && $related->getNamespace() === NS_USER ) {
			return [ $this->userFactory->newFromName( $related->getBaseText() ) ];
		}
		return null;
	}

	/**
	 * @return string
	 */
	public function getKey(): string {
		return 'bs-social-comment-for-user-event';
	}
}
