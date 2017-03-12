<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * @property \App\Model\Table\EventsTable $Events
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
	 * @param string|null $id
	 * @return \Cake\Network\Response|null
	 */
	public function view($id = null) {
		if (empty($id) || !($event = $this->Events->find('first', ['conditions' => ['Events.id' => $id]]))) {
			$this->Flash->error(__('invalidRecord'));
			return $this->Common->autoRedirect(['action' => 'index']);
		}
		$this->set(compact('event'));
	}

	/**
	 * @return \Cake\Network\Response|null
	 */
	public function add() {
		$event = $this->Events->newEntity();
		if ($this->Common->isPosted()) {
			$event = $this->Events->patchEntity($event, $this->request->data);

			if ($this->Events->save($event)) {
				$var = $this->request->data['name'];
				$this->Flash->success(__('record add {0} saved', h($var)));
				return $this->Common->postRedirect(['action' => 'index']);
			}
			$this->Flash->error(__('formContainsErrors'));
		}

		$this->set(compact('event'));
	}

	/**
	 * @param string|null $id
	 * @return \Cake\Network\Response|null
	 */
	public function edit($id = null) {
		if (empty($id) || !($event = $this->Events->find('first', ['conditions' => ['Events.id' => $id]]))) {
			$this->Flash->error(__('invalidRecord'));
			return $this->Common->autoRedirect(['action' => 'index']);
		}
		if ($this->Common->isPosted()) {
			$event = $this->Events->patchEntity($event, $this->request->data);
			if ($this->Events->save($event)) {
				$var = $this->request->data['name'];
				$this->Flash->success(__('record edit {0} saved', h($var)));
				return $this->Common->postRedirect(['action' => 'index']);
			}
			$this->Flash->error(__('formContainsErrors'));
		}

		$this->set(compact('event'));
	}

	/**
	 * @param string|null $id
	 * @return \Cake\Network\Response|null
	 */
	public function delete($id = null) {
		$this->request->allowMethod(['post', 'delete']);
		if (empty($id) || !($event = $this->Events->find('first', ['conditions' => ['Events.id' => $id], 'fields' => ['id', 'name']]))) {
			$this->Flash->error(__('invalidRecord'));
			return $this->Common->autoRedirect(['action' => 'index']);
		}
		$var = $event['name'];

		if ($this->Events->delete($event)) {
			$this->Flash->success(__('record del {0} done', h($var)));
			return $this->Common->postRedirect(['action' => 'index']);
		}
		$this->Flash->error(__('record del {0} not done exception', h($var)));
		return $this->Common->autoRedirect(['action' => 'index']);
	}

}
