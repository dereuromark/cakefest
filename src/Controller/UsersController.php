<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Users Controller
 */
class UsersController extends AppController {

	/**
	 * index method
	 *
	 * @return void
	 */
	public function index() {
		$users = $this->paginate();
		$this->set(compact('users'));
	}

	/**
	 * view method
	 *
	 * @param string $id
	 * @return void
	 */
	public function view($id = null) {
		if (empty($id) || !($user = $this->Users->find('first', array('conditions' => array('User.id' => $id))))) {
			$this->Common->flashMessage(__('invalidRecord'), 'error');
			return $this->Common->autoRedirect(array('action' => 'index'));
		}
		$this->set(compact('user'));
	}

	/**
	 * edit method
	 *
	 * @param string $id
	 * @return void
	 */
	public function edit($id = null) {
		if (empty($id) || !($user = $this->Users->find('first', array('conditions' => array('User.id' => $id))))) {
			$this->Common->flashMessage(__('invalidRecord'), 'error');
			return $this->Common->autoRedirect(array('action' => 'index'));
		}
		if ($this->Common->isPosted()) {
			$this->Users->addBehavior('Tools.Passwordable', array('require' => false));
			if ($this->Users->save($entity)) {
				$var = $this->request->data['User']['username'];
				$this->Common->flashMessage(__('record edit {0} saved', h($var)), 'success');
				return $this->Common->postRedirect(array('action' => 'index'));
			}
			$this->Common->flashMessage(__('formContainsErrors'), 'error');
		} else {
			$this->request->data = $user;
		}
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
		if (empty($id) || !($user = $this->Users->find('first', array('conditions' => array('User.id' => $id), 'fields' => array('id', 'username'))))) {
			$this->Common->flashMessage(__('invalidRecord'), 'error');
			return $this->Common->autoRedirect(array('action' => 'index'));
		}
		$var = $user['username'];

		if ($this->Users->delete($user)) {
			$this->Common->flashMessage(__('record del {0} done', h($var)), 'success');
			return $this->Common->postRedirect(array('action' => 'index'));
		}
		$this->Common->flashMessage(__('record del {0} not done exception', h($var)), 'error');
		return $this->Common->autoRedirect(array('action' => 'index'));
	}

}
