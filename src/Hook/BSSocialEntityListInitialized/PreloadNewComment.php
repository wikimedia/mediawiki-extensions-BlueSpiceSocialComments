<?php

namespace BlueSpice\Social\Comments\Hook\BSSocialEntityListInitialized;

use BlueSpice\Social\Hook\BSSocialEntityListInitialized;
use BlueSpice\Social\EntityListContext\Children;
use BlueSpice\Social\Renderer\EntityList;
use BlueSpice\Social\Comments\Entity\Comment;

class PreloadNewComment extends BSSocialEntityListInitialized {

	protected function skipProcessing() {
		if( !$this->entityList->getContext() instanceof Children ) {
			return true;
		}

		$comment = $this->getServices()->getBSEntityFactory()->newFromObject(
			$this->getRawComment()
		);
		if( !$comment instanceof Comment ) {
			return true;
		}

		$status = $comment->userCan(
			'create',
			$this->entityList->getContext()->getUser()
		);
		if( !$status->isOk() ) {
			return true;
		}

		return false;
	}

	protected function doProcess() {
		//TODO: Check if comments are available in children - for now there are
		//only comments available...
		$this->args[ EntityList::PARAM_PRELOADED_ENTITIES ][]
			= $this->getRawComment();
	}

	protected function getRawComment() {
		return (object)[
			Comment::ATTR_TYPE => Comment::TYPE,
		];
	}

}
