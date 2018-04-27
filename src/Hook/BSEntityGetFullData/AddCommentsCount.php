<?php

namespace BlueSpice\Social\Comments\Hook\BSEntityGetFullData;
use BlueSpice\Hook\BSEntityGetFullData;
use BlueSpice\Social\Entity;
use BlueSpice\Social\Comments\Entity as CommentEntity;

class AddCommentsCount extends BSEntityGetFullData {

	protected function checkEntity() {
		if( !$this->entity->getConfig()->get( 'CanHaveChildren' ) ) {
			return false;
		}
		if( !$this->entity->exists() ) {
			return false;
		}
		if( $this->entity instanceof CommentEntity ) {
			return false;
		}
		return true;
	}

	protected function doProcess() {
		if( !$this->entity instanceof Entity ) {
			return true;
		}
		$this->data[ 'commentcount' ] = 0;
		if( !$this->checkEntity() ) {
			return true;
		}
		$this->data[ 'commentcount' ] = count(
			$this->entity->getChildren( [], [], false, false )
		);
		return true;
	}
}

