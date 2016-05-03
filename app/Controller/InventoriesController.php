<?php

App::uses('AppController', 'Controller');

class InventoriesController extends AppController {

    public $uses = array(
        'Inventory',
        'Product',
        'Stock',
        'StockReceiving',
        'StockReceivingsProduct',
        'StockDelivering',
        'StockDeliveringsProduct',
    );
    protected $stock_id = null;
    protected $begin_at = null;
    protected $end_at = null;
    protected $product_id = array();

    public function index() {

        if ($this->request->is('ajax')) {
            $this->layout = 'ajax';
        }
        $this->setInit();
        $page_title = __('inventory_title');
        $this->set('page_title', $page_title);

        $breadcrumb = array();
        $breadcrumb[] = array(
            'title' => __('home_title'),
            'url' => Router::url(array('controller' => 'DashBoard', 'action' => 'index'))
        );
        $breadcrumb[] = array(
            'title' => __('inventory_title'),
            'url' => Router::url(array('action' => $this->action)),
        );
        $this->set('breadcrumb', $breadcrumb);

        $options = array(
            'order' => array(
                'modified' => 'DESC',
            ),
        );
        $options['recursive'] = -1;
        $page = $this->request->query('page');
        if (!empty($page)) {
            $options['page'] = $page;
        }
        $limit = $this->request->query('limit');
        if (!empty($limit)) {
            $options['limit'] = $limit;
        }
        if (!empty($this->product_id)) {
            $options['conditions']['id'] = $this->product_id;
        }
        if (empty($this->begin_at) || empty($this->end_at)) {
            $options['conditions']['id'] = null;
        }
        $options['conditions']['group_id'] = $this->_getGroup();

        $this->Paginator->settings = $options;

        $list_data = $this->Paginator->paginate($this->Product);
        // tính toán tồn kho
        $this->setQty($list_data);
        $this->set('list_data', $list_data);
    }

    /**
     * setQty
     * Tính tồn kho 
     * 
     * @param array $list_data
     * @return type
     */
    protected function setQty(&$list_data) {

        if (empty($list_data)) {
            return;
        }

        foreach ($list_data as $k => $v) {
            $product_id = $v['Product']['id'];

            // tính tồn đầu kỳ
            $opening_qty = $this->getOpeningQtyByProduct($product_id);
            $list_data[$k]['Product']['opening_qty'] = $opening_qty;

            // tính tồn cuối kỳ
            $closing_qty = $this->getClosingQtyByProduct($product_id);
            $list_data[$k]['Product']['closing_qty'] = $closing_qty;

            // tính số lượng nhập
            $list_data[$k]['Product']['receiving_qty'] = $this->StockReceiving->getQty($product_id, $this->stock_id, $this->begin_at, $this->end_at);

            // tính số lượng xuất
            $list_data[$k]['Product']['delivering_qty'] = $this->StockDelivering->getQty($product_id, $this->stock_id, $this->begin_at, $this->end_at);

            // tính toán dự đoán
            $list_data[$k]['Product']['receiving_qty_forecast'] = 0;
            $list_data[$k]['Product']['delivering_qty_forecast'] = $closing_qty;
        }
    }

    protected function getOpeningQtyByProduct($product_id) {

        $receiving_qty = $this->StockReceiving->getOpeningQty($product_id, $this->stock_id, $this->begin_at);
        $delivering_qty = $this->StockDelivering->getOpeningQty($product_id, $this->stock_id, $this->begin_at);
        return $receiving_qty - $delivering_qty;
    }

    protected function getClosingQtyByProduct($product_id) {

        $receiving_qty = $this->StockReceiving->getClosingQty($product_id, $this->stock_id, $this->end_at);
        $delivering_qty = $this->StockDelivering->getClosingQty($product_id, $this->stock_id, $this->end_at);
        return $receiving_qty - $delivering_qty;
    }

    protected function setInit() {

        $this->set('model_class', $this->modelClass);

        $this->begin_at = $this->request->query('begin_at');
        $this->end_at = $this->request->query('end_at');
        $this->product_id = $this->request->query('product_id');

        // lấy ra danh sách stock
        $stock_lists = $this->Stock->find('all', array(
            'conditions' => array(
                'group_id' => $this->_getGroup()
            )
        ));
        $this->set('stock_lists', $stock_lists);

        $stocks = array();
        if (!empty($stock_lists)) {
            foreach ($stock_lists as $v) {
                $stocks[$v['Stock']['id']] = $v['Stock']['name'];
            }
        }
        $this->set('stocks', $stocks);

        $stock_codes = array();
        if (!empty($stock_lists)) {
            foreach ($stock_lists as $v) {
                $stock_codes[$v['Stock']['id']] = $v['Stock']['code'];
            }
        }
        $this->set('stock_codes', $stock_codes);

        $this->stock_id = $this->request->query('stock_id');
        // nếu stock_id chưa được thiết lập, thì lấy mặc định stock_id là giá trị đầu tiên trong $stocks
        if (empty($this->stock_id) && !empty($stocks)) {
            $this->stock_id = array_keys($stocks)[0];
        }
        $this->set('stock_id', $this->stock_id);

        // lấy ra danh sách product
        $products = $this->Product->find('list', array(
            'conditions' => array(
                'group_id' => $this->_getGroup()
            )
        ));
        $this->set('products', $products);
    }

}
