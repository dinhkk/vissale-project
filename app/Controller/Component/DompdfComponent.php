<?php
/**
 * Created by PhpStorm.
 * User: dinhkk
 * Date: 6/30/16
 * Time: 11:47 AM
 */

App::uses('Component', 'Controller');

/**
 * Component for working with PHPExcel class.
 *
 * @package PhpExcel
 * @author segy
 */
class DompdfComponent extends Component {

     public function getInstance()
    {
        $instance = new \Dompdf\Dompdf();
        return $instance;
    }
    
}