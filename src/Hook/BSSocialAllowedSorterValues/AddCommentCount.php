<?php

namespace BlueSpice\Social\Comments\Hook\BSSocialAllowedSorterValues;
use BlueSpice\Social\Hook\BSSocialAllowedSorterValues;

class AddCommentCount extends BSSocialAllowedSorterValues {
	protected function doProcess() {
		$this->aSorters[] = 'commentcount';
		return true;
	}
}
