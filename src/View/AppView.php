<?php
namespace App\View;

use Cake\View\View;

/**
 * @property \AssetCompress\View\Helper\AssetCompressHelper $AssetCompress
 * @property \Tools\View\Helper\FormHelper $Format
 * @property \TinyAuth\View\Helper\AuthUserHelper $AuthUser
 * @property \Geo\View\Helper\GoogleMapHelper $GoogleMap
 * @property \Tools\View\Helper\FormatHelper $Format
 * @property \Tools\View\Helper\ObfuscateHelper $Obfuscate
 * @property \Tools\View\Helper\TimelineHelper $Timeline
 * @property \App\View\Helper\CakefestHelper $Cakefest
 */
class AppView extends View {

	/**
	 * Initialization hook method.
	 *
	 * For e.g. use this method to load a helper for all views:
	 * `$this->loadHelper('Html');`
	 *
	 * @return void
	 */
	public function initialize() {
	}

}
