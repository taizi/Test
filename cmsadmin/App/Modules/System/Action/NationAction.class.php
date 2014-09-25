<?php

class NationAction extends BaseAction {
	
	
	protected function allNations(){
		return A('Nation','Event',TRUE)->allNations();
	}
	
}

?>