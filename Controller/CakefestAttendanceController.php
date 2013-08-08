<?php
App::uses('AppController', 'Controller');
/**
 * CakefestAttendance Controller
 *
 * @property CakefestAttendance $CakefestAttendance
 * @property PaginatorComponent $Paginator
 */
class CakefestAttendanceController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->CakefestAttendance->recursive = 0;
		$this->set('cakefestAttendance', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->CakefestAttendance->exists($id)) {
			throw new NotFoundException(__('Invalid cakefest attendance'));
		}
		$options = array('conditions' => array('CakefestAttendance.' . $this->CakefestAttendance->primaryKey => $id));
		$this->set('cakefestAttendance', $this->CakefestAttendance->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->CakefestAttendance->create();
			if ($this->CakefestAttendance->save($this->request->data)) {
				$this->Session->setFlash(__('The cakefest attendance has been saved'));
				return $this->redirect(array('action' => 'index'));
			}
			$this->Session->setFlash(__('The cakefest attendance could not be saved. Please, try again.'));
		}
		$users = $this->CakefestAttendance->User->find('list');
		$this->set(compact('users'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->CakefestAttendance->exists($id)) {
			throw new NotFoundException(__('Invalid cakefest attendance'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->CakefestAttendance->save($this->request->data)) {
				$this->Session->setFlash(__('The cakefest attendance has been saved'));
				return $this->redirect(array('action' => 'index'));
			}
			$this->Session->setFlash(__('The cakefest attendance could not be saved. Please, try again.'));

		} else {
			$options = array('conditions' => array('CakefestAttendance.' . $this->CakefestAttendance->primaryKey => $id));
			$this->request->data = $this->CakefestAttendance->find('first', $options);
		}
		$users = $this->CakefestAttendance->User->find('list');
		$this->set(compact('users'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->CakefestAttendance->id = $id;
		if (!$this->CakefestAttendance->exists()) {
			throw new NotFoundException(__('Invalid cakefest attendance'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->CakefestAttendance->delete()) {
			$this->Session->setFlash(__('Cakefest attendance deleted'));
			return $this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Cakefest attendance was not deleted'));
		return $this->redirect(array('action' => 'index'));
	}
}
