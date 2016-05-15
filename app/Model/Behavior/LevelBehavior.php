<?php

class LevelBehavior extends ModelBehavior {

    public function beforeFind(\Model $model, $query) {
        parent::beforeFind($model, $query);

        $user = CakeSession::read('Auth.User');
        if (empty($user)) {
            return true;
        }
        if (empty($user['level'])) {
            return true;
        }
        // thực hiện kiểm tra level của user
        $level = $user['level'];

        // nếu mức level lớn hơn ADMINSYSTEM thì không thực hiện lọc
        if ($level >= ADMINSYSTEM) {
            return true;
        }
        // nếu mức level lớn hơn ADMINGROUP thì thực hiện lọc theo group_id
        if ($level <= ADMINGROUP) {
            if ($model->schema('group_id')) {
                $query['conditions'][$model->alias . '.group_id'] = $user['group_id'];
            }
            // riêng đối với status, khi lấy ra thêm vào group_id mặc định của hệ thống
            if ($model->schema('group_id') && $model->alias == 'Status') {
                $query['conditions'][$model->alias . '.group_id'][] = SYSTEM_GROUP_ID;
            }
            return $query;
        }
        // nếu mức level nhỏ hơn  USERGROUP thì thực hiện lọc theo group_id và status_id
        if ($level <= USERGROUP) {
            if ($model->schema('status_id')) {
                // thực hiện parse lấy status_id được cache trong Auth.User.data
                $data_encode = $user['data'];
                $data = json_decode($data_encode, true);
                $status_id = $data['status_id'];
                $query['conditions'][$model->alias . '.status_id'] = $status_id;
            }
            return $query;
        }
        return true;
    }

}
