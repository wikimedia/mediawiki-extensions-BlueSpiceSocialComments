<?php

namespace BlueSpice\Social\Comments\Hook\BSSocialModuleDepths;

use BlueSpice\Social\Hook\BSSocialModuleDepths;

class AddModules extends BSSocialModuleDepths {

	protected function doProcess() {
		$this->aVarMsgKeys['commentcount']
			= 'bs-socialcomments-var-commentcount';

		return true;
	}
}
