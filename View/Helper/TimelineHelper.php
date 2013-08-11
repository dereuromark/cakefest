<?php

App::uses('AppHelper', 'View/Helper');

/**
 * TimelineHelper for easy output of a timeline with multiple items.
 *
 * Uses http://almende.github.io/chap-links-library/timeline.html
 */
class TimelineHelper extends AppHelper {

	public $helpers = array('Js');

	protected $_defaults = array(
		'id' => 'mytimeline',
		'selectable' => false,
		'editable' => false,
		'min' => null,
		'max' => null,
		'width' => '100%',
		'height' => null, // Auto.
		'style' => 'box',
	);

	protected $_items = array();

	/**
	 * Constructor
	 *
	 * @param View $View The View this helper is being attached to.
	 * @param array $settings Configuration settings for the helper.
	 */
	public function __construct(View $View, $settings = array()) {
		$this->settings = $this->_defaults;
		parent::__construct($View, $settings);
	}

	/**
	 * Apply settings and merge them with the defaults.
	 *
	 * @return void
	 */
	public function settings($settings) {
		$this->settings = Hash::merge($this->settings, $settings);
	}

	/**
	 * Add timeline item.
	 *
	 * Requires at least:
	 * - start (date or datetime)
	 * - content (string)
	 * Further data options:
	 * - end (date or datetime)
	 * - group (string)
	 * - className (string)
	 * - editable (boolean)
	 *
	 * @link http://almende.github.io/chap-links-library/js/timeline/doc/
	 * @param array
	 * @return void
	 */
	public function addItem($item) {
		$this->_items[] = $item;
	}

	/**
	 * Add timeline items as an array of items.
	 *
	 * @see TimelineHelper::addItem()
	 * @return void
	 */
	public function addItems($items) {
		foreach ($items as $item) {
			$this->_items[] = $item;
		}
	}

	/**
	 * Finalize the timeline and write the javascript to the buffer.
	 * Make sure that your view does also output the buffer at some place!
	 *
	 * @param boolean $return If the output should be returned instead
	 * @return void or string Javascript if $return is true
	 */
	public function finalize($return = false) {
		$timelineId = $this->settings['id'];
		$data = $this->_format($this->_items);
		$script = <<<JS
var timeline;
var data;
var options;

// Called when the Visualization API is loaded.
function drawVisualization() {
	// Create a JSON data table
	data = $data

	// specify options
	options = {
	    'width':  '100%',
	    //'height': '300px',
	    'editable': false,
	    'style': 'box',
	    'min': new Date(2013, 08, 18),
	    'max': new Date(2013, 09, 13),
	    'selectable': false
	};

	// Instantiate our timeline object.
	timeline = new links.Timeline(document.getElementById('$timelineId'));

	// Draw our timeline with the created data and options
	timeline.draw(data, options);
}

drawVisualization();
JS;
		if ($return) {
			return $script;
		}
		$this->Js->buffer($script);
	}

	public function _format($items) {
		$e = array();
		foreach ($items as $item) {
			$tmp = array();
			foreach ($item as $key => $row) {
				switch ($key) {
					case 'editable':
						$tmp[] = $row ? 'true' : 'false';
						break;
					case 'start':
					case 'end':
						$tmp[] = '\'' . $key . '\': ' . $this->_date($row);
						break;
					default:
						$tmp[] = '\'' .$key . '\': \'' . ($row) . '\'';
				}
			}
			$e[] = '{' . implode(',' . PHP_EOL, $tmp) . '}';
		}
		$string = '[' . implode(',' . PHP_EOL, $e) . '];';

		return $string;
	}

	protected function _date($date) {
		$dateTime = explode(' ', $date, 2);
		$datePieces = array();
		$datePieces[] = (int)substr($date, 0, 4);
		$datePieces[] = (int)substr($date, 5, 2);
		$datePieces[] = (int)substr($date, 8, 2);
		if (!empty($dateTime[1])) {
			//TODO
			$datePieces[] = (int)substr($date, 0, 2);
			$datePieces[] = (int)substr($date, 3, 2);
			$datePieces[] = (int)substr($date, 6, 2);
		}
		return 'new Date(' . implode(', ', $datePieces) . ')';
	}

}
