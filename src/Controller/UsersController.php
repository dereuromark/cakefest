<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Users Controller
 */
class UsersController extends AppController {

	public $components = [
		'Search.Prg'
	];

	/**
	 * index method
	 *
	 * @return void
	 */
	public function index() {
		$this->Prg->commonProcess();

		$users = $this->paginate($this->Users->find('searchable', $this->Prg->parsedParams()));
		$this->set(compact('users'));
	}

	/**
	 * view method
	 *
	 * @param string $id
	 * @return void
	 */
	public function view($id = null) {
		$user = $this->Users->get($id);

		$this->set(compact('user'));
	}

	/**
	 * edit method
	 *
	 * @param string $id
	 * @return void
	 */
	public function edit($id = null) {
		if (empty($id) || !($user = $this->Users->find('first', ['conditions' => ['Users.id' => $id]]))) {
			$this->Flash->message(__('invalidRecord'), 'error');
			return $this->Common->autoRedirect(['action' => 'index']);
		}
		if ($this->Common->isPosted()) {
			$user = $this->Users->patchEntity($user, $this->request->data);
			$this->Users->addBehavior('Tools.Passwordable', ['require' => false]);
			if ($this->Users->save($user)) {
				$var = $this->request->data['username'];
				$this->Flash->message(__('record edit {0} saved', h($var)), 'success');
				return $this->Common->postRedirect(['action' => 'index']);
			}
			$this->Flash->message(__('formContainsErrors'), 'error');
		}

		$this->set(compact('user'));
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
		if (empty($id) || !($user = $this->Users->find('first', ['conditions' => ['Users.id' => $id], 'fields' => ['id', 'username']]))) {
			$this->Flash->message(__('invalidRecord'), 'error');
			return $this->Common->autoRedirect(['action' => 'index']);
		}
		$var = $user['username'];

		if ($this->Users->delete($user)) {
			$this->Flash->message(__('record del {0} done', h($var)), 'success');
			return $this->Common->postRedirect(['action' => 'index']);
		}
		$this->Flash->message(__('record del {0} not done exception', h($var)), 'error');
		return $this->Common->autoRedirect(['action' => 'index']);
	}

}
