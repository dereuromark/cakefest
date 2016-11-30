<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Users Controller
 */
class UsersController extends AppController {

	/**
	 * @var array
	 */
	public $components = [
		'Search.Prg'
	];

	/**
	 * @return void
	 */
	public function index() {
		$this->Prg->commonProcess();

		$users = $this->paginate($this->Users->find('searchable', $this->Prg->parsedParams()));
		$this->set(compact('users'));
	}

	/**
	 * @param string|null $id
	 * @return void
	 */
	public function view($id = null) {
		$user = $this->Users->get($id);

		$this->set(compact('user'));
	}

	/**
	 * @param string|null $id
	 * @return void
	 */
	public function edit($id = null) {
		if (empty($id) || !($user = $this->Users->find('first', ['conditions' => ['Users.id' => $id]]))) {
			$this->Flash->error(__('invalidRecord'));
			return $this->Common->autoRedirect(['action' => 'index']);
		}
		if ($this->Common->isPosted()) {
			$user = $this->Users->patchEntity($user, $this->request->data);
			$this->Users->addBehavior('Tools.Passwordable', ['require' => false]);
			if ($this->Users->save($user)) {
				$var = $this->request->data['username'];
				$this->Flash->success(__('record edit {0} saved', h($var)));
				return $this->Common->postRedirect(['action' => 'index']);
			}
			$this->Flash->error(__('formContainsErrors'));
		}

		$this->set(compact('user'));
	}

	/**
	 * delete method
	 *
	 * @param string|null $id
	 * @return void
	 */
	public function delete($id = null) {
		$this->request->allowMethod(['post', 'delete']);
		if (empty($id) || !($user = $this->Users->find('first', ['conditions' => ['Users.id' => $id], 'fields' => ['id', 'username']]))) {
			$this->Flash->error(__('invalidRecord'));
			return $this->Common->autoRedirect(['action' => 'index']);
		}
		$var = $user['username'];

		if ($this->Users->delete($user)) {
			$this->Flash->success(__('record del {0} done', h($var)));
			return $this->Common->postRedirect(['action' => 'index']);
		}
		$this->Flash->error(__('record del {0} not done exception', h($var)));
		return $this->Common->autoRedirect(['action' => 'index']);
	}

}
