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
	 * @param string $id
	 * @return \Cake\Network\Response|null
	 */
	public function view($id = null) {
		if (empty($id) || !($event = $this->Events->find('first', ['conditions' => ['Events.id' => $id]]))) {
			$this->Flash->message(__('invalidRecord'), 'error');
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
				$this->Flash->message(__('record add {0} saved', h($var)), 'success');
				return $this->Common->postRedirect(['action' => 'index']);
			}
			$this->Flash->message(__('formContainsErrors'), 'error');
		}

		$this->set(compact('event'));
	}

	/**
	 * @param string $id
	 * @return \Cake\Network\Response|null
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
	 * @param string $id
	 * @return \Cake\Network\Response|null
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
