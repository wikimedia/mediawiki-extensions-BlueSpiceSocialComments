<?php

namespace BlueSpice\Social\Comments\Hook\BSSocialEntityOutputRenderAfterContent;
use BlueSpice\Social\Hook\BSSocialEntityOutputRenderAfterContent;
use BlueSpice\Social\Entity;

/**
 * Adds a comment count to every non comment entity view
 */
class AddCommentSection extends BSSocialEntityOutputRenderAfterContent {

	protected function doProcess() {
		$oEntity = $this->oEntityOutput->getEntity();

		if( !$oEntity instanceof Entity ) {
			return true;
		}
		if( !$oEntity->exists() || $oEntity->hasParent() ) {
			return true;
		}
		if( !$oEntity->getConfig()->get( 'CanHaveChildren' ) ) {
			return true;
		}

		$sView = '';
		$aChildren = $oEntity->getChildren(
			[],
			["type" => "comment"]
		);

		$sView .= \XML::openElement( "a", [
			'class' => 'bs-social-entityaftercontent-comment'
		]);
		$sView .= wfMessage(
			'bs-socialcomments-commenttext',
			count( $aChildren )
		)->parse();
		$sView .= \XML::closeElement( "a" );

		$this->aViews[] = $sView;
		return true;
	}
}