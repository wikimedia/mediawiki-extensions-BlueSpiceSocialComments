<?php

namespace BlueSpice\Social\Comments\Hook\BSSocialEntityOutputRenderBeforeChildren;
use BlueSpice\Social\Hook\BSSocialEntityOutputRenderBeforeChildren;
use BlueSpice\Social\Entity;
/**
 * Adds a comment edit form
 */
class AddEmptyComment extends BSSocialEntityOutputRenderBeforeChildren {

	protected function doProcess() {
		$oEntity = $this->oEntityOutput->getEntity();
		if( !$oEntity || !$oEntity->exists() || $oEntity->hasParent() ) {
			return true;
		}
		if( !$oEntity->getConfig()->get( 'CanHaveChildren' ) ) {
			return true;
		}
		$oUser = $this->getContext()->getUser();
		if( !$oUser || $oUser->isAnon() ) {
			return true;
		}

		$entityFactory = $this->getServices()->getService(
			'BSEntityFactory'
		);
		$entity = $entityFactory->newFromObject( (object) [
			'type' => 'comment',
			'parentid' => $oEntity->get( Entity::ATTR_ID ),
		]);
		if( !$entity ) {
			return true;
		}

		$this->aViews[] = $entity->render();
		return true;
	}
}