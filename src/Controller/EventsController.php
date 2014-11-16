<?php
namespace App\Controller;
use App\Controller\AppController;
/**
 * Events Controller
 *
 * @property Event $Event
 */
class EventsController extends AppController {

	/**
	 * index method
	 *
	 * @return void
	 */
	public function index() {
		$events = $this->paginate();
		$this->set(compact('events'));
	}

	/**
	 * view method
	 *
	 * @param string $id
	 * @return void
	 */
	public function view($id = null) {
		if (empty($id) || !($event = $this->Events->find('first', array('conditions' => array('Events.id' => $id))))) {
			$this->Common->flashMessage(__('invalidRecord'), 'error');
			return $this->Common->autoRedirect(array('action' => 'index'));
		}
		$this->set(compact('event'));
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function add() {
		$event = $this->Events->newEntity($this->request->data);
		if ($this->Common->isPosted()) {
			if ($this->Events->save($event)) {
				$var = $this->request->data['name'];
				$this->Common->flashMessage(__('record add {0} saved', h($var)), 'success');
				return $this->Common->postRedirect(array('action' => 'index'));
			}
			$this->Common->flashMessage(__('formContainsErrors'), 'error');
		}
	}

	/**
	 * edit method
	 *
	 * @param string $id
	 * @return void
	 */
	public function edit($id = null) {
		if (empty($id) || !($event = $this->Events->find('first', array('conditions' => array('Events.id' => $id))))) {
			$this->Common->flashMessage(__('invalidRecord'), 'error');
			return $this->Common->autoRedirect(array('action' => 'index'));
		}
		if ($this->Common->isPosted()) {
			$event = $this->Events->patchEntity($event, $this->request->data);
			if ($this->Events->save($event)) {
				$var = $this->request->data['name'];
				$this->Common->flashMessage(__('record edit {0} saved', h($var)), 'success');
				return $this->Common->postRedirect(array('action' => 'index'));
			}
			$this->Common->flashMessage(__('formContainsErrors'), 'error');
		}

		$this->set(compact('event'));
	}

	/**
	 * delete method
	 *
	 * @throws MethodNotAllowedException
	 * @param string $id
	 * @return void
	 */
	public function delete($id = null) {
		$this->request->allowMethod('post', 'delete');
		if (empty($id) || !($event = $this->Events->find('first', array('conditions' => array('Events.id' => $id), 'fields' => array('id', 'name'))))) {
			$this->Common->flashMessage(__('invalidRecord'), 'error');
			return $this->Common->autoRedirect(array('action' => 'index'));
		}
		$var = $event['name'];

		if ($this->Events->delete($event)) {
			$this->Common->flashMessage(__('record del {0} done', h($var)), 'success');
			return $this->Common->postRedirect(array('action' => 'index'));
		}
		$this->Common->flashMessage(__('record del {0} not done exception', h($var)), 'error');
		return $this->Common->autoRedirect(array('action' => 'index'));
	}

}
