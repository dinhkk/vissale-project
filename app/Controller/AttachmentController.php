<?php
/**
 * Created by PhpStorm.
 * User: dinhkk
 * Date: 11/12/16
 * Time: 4:32 PM
 */


App::uses('AppController', 'Controller');
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');


class AttachmentController extends AppController
{

    public function beforeFilter()
    {
        //Configure AuthComponent
        $this->PermLimit->allow(array(
            'uploadFile',
        ));
    }

    public function uploadFile()
    {
        $message = array(
            'error' => 1,
            'message' => 'Lỗi upload file !',
            'data' => null
        );

        if (!$this->request->is("post")) {
            die('Request is forbidden.');
        }

        if (!$this->request->data['conversation_id']) {
            die('Request is forbidden.');
        }

        try {
            $fileData = $_FILES;
            $conversionId = $this->request->data['conversation_id'];
            $folder = new Folder(WWW_ROOT);
            $relativePath = "files/{$conversionId}";
            $folder->create($relativePath);
            $folder->cd($relativePath);

            $file = new File($fileData['file_message']['tmp_name'], true, 0664);

            $newFilename = uniqid('vissale_') . $this->seoUrl($fileData['file_message']['name']);

            $fileCopyPath = $folder->pwd() . "/" . $newFilename;
            $file->copy($fileCopyPath, true);
            $copiedFile = new File($fileCopyPath);

            if ($copiedFile->readable()) {
                $message['error'] = 0;
                $message['message'] = 'Upload file thành công!';
                $message['data'] = "https://" . $_SERVER['SERVER_NAME'] . "/file.php?path={$conversionId}/{$newFilename}";

                echo json_encode($message);
                die;
            }

        } catch (Exception $e) {
            echo json_encode($message);
            die;
        }

        die('error');
    }

}