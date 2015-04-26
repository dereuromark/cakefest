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
		if (empty($id) || !($event = $this->Events->find('first', ['conditions' => ['Events.id' => $id]]))) {
			$this->Flash->message(__('invalidRecord'), 'error');
			return $this->Common->autoRedirect(['action' => 'index']);
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
				$this->Flash->message(__('record add {0} saved', h($var)), 'success');
				return $this->Common->postRedirect(['action' => 'index']);
			}
			$this->Flash->message(__('formContainsErrors'), 'error');
		}

		$this->set(compact('event'));
	}

	/**
	 * edit method
	 *
	 * @param string $id
	 * @return void
	 */
	public function edit($id = null) {
		if (empty($id) || !($event = $this->Events->find('first', ['conditions' => ['Events.id' => $id]]))) {
			$this->Flash->message(__('invalidRecord'), 'error');
			return $this->Common->autoRedirect(['action' => 'index']);
		}
		if ($this->Common->isPosted()) {
			$event = $this->Events->patchEntity($event, $this->request->data);
			if ($this->Events->save($event)) {
				$var = $this->request->data['name'];
				$this->Flash->message(__('record edit {0} saved', h($var)), 'success');
				return $this->Common->postRedirect(['action' => 'index']);
			}
			$this->Flash->message(__('formContainsErrors'), 'error');
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
		$this->request->allowMethod(['post', 'delete']);
		if (empty($id) || !($event = $this->Events->find('first', ['conditions' => ['Events.id' => $id], 'fields' => ['id', 'name']]))) {
			$this->Flash->message(__('invalidRecord'), 'error');
			return $this->Common->autoRedirect(['action' => 'index']);
		}
		$var = $event['name'];

		if ($this->Events->delete($event)) {
			$this->Flash->message(__('record del {0} done', h($var)), 'success');
			return $this->Common->postRedirect(['action' => 'index']);
		}
		$this->Flash->message(__('record del {0} not done exception', h($var)), 'error');
		return $this->Common->autoRedirect(['action' => 'index']);
	}

}
