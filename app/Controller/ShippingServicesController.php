<?php
App::uses ( 'AppController', 'Controller' );

class ShippingServicesController extends AppController {

	public $components = array(
		"PhpExcel"
	);

	/**
	 * Scaffold
	 *
	 * @var mixed
	 */
	// public $scaffold;
	public function index() {
		if ($this->request->is ( 'ajax' )) {
			$this->layout = 'ajax';
		}
		$this->setInit ();
		$page_title = __ ( 'shipping_services_title' );
		$this->set ( 'page_title', $page_title );
		
		$breadcrumb = array ();
		$breadcrumb [] = array (
				'title' => __ ( 'home_title' ),
				'url' => Router::url ( array (
						'controller' => 'DashBoard',
						'action' => 'index' 
				) ) 
		);
		$breadcrumb [] = array (
				'title' => __ ( 'shipping_services_title' ),
				'url' => Router::url ( array (
						'action' => $this->action 
				) ) 
		);
		$this->set ( 'breadcrumb', $breadcrumb );
		
		$options = array (
				'order' => array (
						'modified' => 'DESC' 
				) 
		);
		
		$options ['recursive'] = - 1;
		$page = $this->request->query ( 'page' );
		if (! empty ( $page )) {
			$options ['page'] = $page;
		}
		$limit = $this->request->query ( 'limit' );
		if (! empty ( $limit )) {
			$options ['limit'] = $limit;
		}
		$this->Prg->commonProcess ();
		$options ['conditions'] = $this->{$this->modelClass}->parseCriteria ( $this->Prg->parsedParams () );

		$this->Paginator->settings = $options;
		
		$list_data = $this->Paginator->paginate ();
		
		// debug( $list_data ); die;
		
		$this->set ( 'list_data', $list_data );
	}
	protected function setInit() {
		$this->set ( 'model_class', $this->modelClass );
	}
	public function reqAdd() {

		$this->autoRender = false;
		
		if ($this->request->is ( 'ajax' )) {
			$res = array ();
			$save_data = $this->request->data;
			
			// debug( $save_data ); die;
			
			if ($this->{$this->modelClass}->save ( $save_data )) {
				$res ['error'] = 0;
				$res ['data'] = null;
				echo json_encode ( $res );
			} else {
				$res ['error'] = 1;
				$res ['data'] = array (
						'validationErrors' => $this->{$this->modelClass}->validationErrors 
				);
				$this->layout = 'ajax';
				$this->set ( 'model_class', $this->modelClass );
				$render = $this->render ( 'req_add' );
				$res ['data'] ['html'] = $render->body ();
				echo json_encode ( $res );
				exit ();
			}
		}
	}
	public function reqEdit($id = null) {
		if (! $this->{$this->modelClass}->exists ( $id )) {
			throw new NotFoundException ( __ ( 'invalid_data' ) );
		}
		$this->autoRender = false;
		if ($this->request->is ( 'ajax' )) {
			$res = array ();
			$save_data = $this->request->data;
			if ($this->{$this->modelClass}->save ( $save_data )) {
				$res ['error'] = 0;
				$res ['data'] = null;
			} else {
				$res ['error'] = 1;
				$res ['data'] = array (
						'validationErrors' => $this->{$this->modelClass}->validationErrors 
				);
				$this->layout = 'ajax';
				$this->set ( 'model_class', $this->modelClass );
				$this->set ( 'id', $id );
				$render = $this->render ( 'req_edit' );
				$res ['data'] ['html'] = $render->body ();
				echo json_encode ( $res );
				exit ();
			}
			echo json_encode ( $res );
		}
	}
	public function reqDelete($id = null) {
		if (! $this->{$this->modelClass}->exists ( $id )) {
			throw new NotFoundException ( __ ( 'invalid_data' ) );
		}
		$this->autoRender = false;
		if ($this->request->is ( 'ajax' )) {
			$res = array ();
			if ($this->{$this->modelClass}->delete ( $id )) {
				$res ['error'] = 0;
				$res ['data'] = null;
			} else {
				$res ['error'] = 1;
				$res ['data'] = null;
			}
			echo json_encode ( $res );
		}
	}

	public function import()
	{
		if ($this->request->is("post")) {
			$data = $this->request->data;

			if ( empty($data["ImportPostCode"]["uploaded_file"]) ) {
				$this->doUploadNewExcelFile($data);
			}

			if ( !empty($data["ImportPostCode"]["uploaded_file"]) ) {
				$this->doRequestAction($data);
			}
		}
	}

	private function reStructureExcel($dataExcelObject, $header)
	{
		$highestRow = $dataExcelObject->getHighestRow(); // e.g. 10
		$highestColumn = $dataExcelObject->getHighestColumn(); // e.g 'F'
		$new_header = array(
			"STT",
			"MA_DON_HANG",
			"SO_HIEU",
			"NGAY_KG",
			"KHOI_LUONG",
			"TRI_GIA",
			"TONG_CUOC"
		);


		$newData = array();
		$newData[0] = $new_header;


		foreach ($dataExcelObject->getRowIterator() as $row => $row_data)  {
			
			$cellIterator = $row_data->getCellIterator();
			$cellIterator->setIterateOnlyExistingCells(TRUE);

			if ($row == 1) {
				continue;
			}

			$data_row = [$row-1, null, null, null, null, null, null];


			foreach ($cellIterator as $column =>  $cell) {

				if ( array_search("MA_DON_HANG", $header) == $column) {
					$data_row[1] = $cell->getValue();
				}

				if ( array_search("SO_HIEU", $header) == $column) {
					$data_row[2] = $cell->getValue();;
				}

				if ( array_search("NGAY_KG", $header) == $column) {
					$data_row[3] = $cell->getValue();;
				}

				if ( array_search("KHOI_LUONG", $header) == $column) {
					$data_row[4] = $cell->getValue();;
				}

				if ( array_search("TRI_GIA", $header) == $column) {
					$data_row[5] = $cell->getValue();;
				}

				if ( array_search("TONG_CUOC", $header) == $column) {
					$data_row[6] = $cell->getValue();;
				}

			}

			if (!$data_row[1] && !$data_row[2]) {
				continue;
			}

			$newData[] = $data_row;

		}

		return $newData;
	}
	
	private function isValidExcel($header){
		if (!in_array("MA_DON_HANG", $header) || !in_array("SO_HIEU", $header)){
			return false;
		}
		return true;
	}

	private function doUploadNewExcelFile($data)
	{
		//if uploaded file is  new
		$file = $data["ImportPostCode"]['excel_file']["tmp_name"];

		$this->PhpExcel->loadWorksheet($file);
		$objWorksheet = $this->PhpExcel->getActiveSheet();

		//format the excel column
		$header = [];
		foreach ($objWorksheet->getRowIterator() as $row => $row_data)  {
			$cellIterator = $row_data->getCellIterator();
			$cellIterator->setIterateOnlyExistingCells(true);
			if($row > 1){
				break;
			}
			foreach ($cellIterator as $column =>  $cell) {
				$header[$column] = $cell->getValue();
			}
		}

		$test = $this->isValidExcel($header);
		if (!$test) {
			$this->set("error", "Không tìm thấy cột MA_DON_HANG hoặc SO_HIEU");
			$this->set("objWorksheet", null);
			return;
		}

		//write new data to file
		$newData = $this->reStructureExcel($objWorksheet, $header);

		$newExcelObject =  new PhpExcel();

		$newExcelObject->getActiveSheet()
			->fromArray(
				$newData,  // The data to set
				NULL,  // Array values with this value will not be set
				'A1'         // Top left coordinate of the worksheet range where
			//    we want to set these values (default is A1)
			);
		$objWriter = PHPExcel_IOFactory::createWriter($newExcelObject, "Excel2007");
		$objWriter->save($file);

		//read new file;
		$this->PhpExcel->loadWorksheet($file);
		$objWorksheet = $this->PhpExcel->getActiveSheet();

		$this->set("objWorksheet", $objWorksheet);
		$this->set("uploaded_file", $file);
	}

	private function doRequestAction($data)
	{
		$action = $data["ImportPostCode"]["action"];

		if ($action=="validate_data") {

			$file = $data["ImportPostCode"]["uploaded_file"];
			$this->validateUploadedExcel($file);
		}

		if ($action == "do_import_data") {
			$this->doImportPostCodes($data);
		}

	}

	private function validateUploadedExcel($file)
	{
		$objReader = PHPExcel_IOFactory::createReader("Excel2007");
		$objPHPExcel = $objReader->load($file);
		$objWorksheet = $objPHPExcel->getActiveSheet();

		$excel_codes = [];
		foreach ($objWorksheet->getRowIterator() as $row => $row_data) {
			$cellIterator = $row_data->getCellIterator();
			$cellIterator->setIterateOnlyExistingCells(FALSE);

			foreach ($cellIterator as $column => $cell) {

					if ($column==2){
						$excel_codes = $cell->getValue();
					}

			}
		}

		debug($excel_codes); die;

	}

	private function doImportPostCodes($data)
	{

	}
}