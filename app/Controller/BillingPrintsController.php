<?php
App::uses('AppController', 'Controller');
/**
 * BillingPrints Controller
 *
 * @property BillingPrint $BillingPrint
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 * @property ''Component $''
 * @property SessionComponent $Session
 */
class BillingPrintsController extends AppController {

/**
 * Helpers
 *
 * @var array
 */
	public $helpers = array('Text', 'Js', 'Time');

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Flash', 'Session', 'Dompdf');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		//$this->BillingPrint->recursive = 0;
		//$this->set('billingPrints', $this->Paginator->paginate());
		$print = $this->BillingPrint->find("first");
		$_data = unserialize($print["BillingPrint"]["data"]);
		$this->set("data", $_data);

		if ($this->request->is("post")) {
			$data = $this->request->data;
			$print["BillingPrint"]["data"] = serialize($data);
			$this->BillingPrint->save($print["BillingPrint"]);
			return $this->redirect(["action"=>"index"]);
		}
		return;
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->BillingPrint->exists($id)) {
			throw new NotFoundException(__('Invalid billing print'));
		}
		$options = array('conditions' => array('BillingPrint.' . $this->BillingPrint->primaryKey => $id));
		$this->set('billingPrint', $this->BillingPrint->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->BillingPrint->create();
			if ($this->BillingPrint->save($this->request->data)) {
				$this->Flash->success(__('The billing print has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The billing print could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->BillingPrint->exists($id)) {
			throw new NotFoundException(__('Invalid billing print'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->BillingPrint->save($this->request->data)) {
				$this->Flash->success(__('The billing print has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The billing print could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('BillingPrint.' . $this->BillingPrint->primaryKey => $id));
			$this->request->data = $this->BillingPrint->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->BillingPrint->id = $id;
		if (!$this->BillingPrint->exists()) {
			throw new NotFoundException(__('Invalid billing print'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->BillingPrint->delete()) {
			$this->Flash->success(__('The billing print has been deleted.'));
		} else {
			$this->Flash->error(__('The billing print could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}


	public function printSingleOrder($data = null)
	{
		Cache::clear();

		$view = new View($this,false);
		$view->viewPath='Elements';
		$view->layout=false;


		$html = $view->render('tpl_print_order');

		//
		$dompdf = $this->Dompdf->getInstance();

		$dompdf->loadHtml( $html );

		// (Optional) Setup the paper size and orientation
		$dompdf->setPaper('A4', 'portrait');

		// Render the HTML as PDF
		$dompdf->render();

		// Output the generated PDF to Browser
		$dompdf->stream("BillingInformation", array("Attachment"=>0) );
	}

	public function printOrders($data = null)
	{

	}

	public function previewOrderPrint()
	{
		Cache::clear();

		$view = new View($this,false);
		$view->viewPath='Elements';
		$view->layout=false;

		$print = $this->BillingPrint->find("first");
		$_data = unserialize($print["BillingPrint"]["data"]);
		$view->set("data", $_data);
		
		$view->set('page_title', "preview Order Print");


		$html=$view->render('preview_order_print');

		//
		$dompdf = $this->Dompdf->getInstance();

		$dompdf->loadHtml( $html );

		// (Optional) Setup the paper size and orientation
		$dompdf->setPaper('A4', 'portrait');

		// Render the HTML as PDF
		$dompdf->render();

		// Output the generated PDF to Browser
		$dompdf->stream("previewOrderPrint", array("Attachment"=>0) );
	}
}
