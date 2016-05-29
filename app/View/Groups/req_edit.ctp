<td>
    <button type="button" class="btn default" data-toggle="collapse" data-target="#edit-form-<?php echo $id ?>"><?php echo __('cancel_btn') ?></button>
    <button type="button" class="btn blue ajax-submit" id="edit-form-submit"><?php echo __('save_btn') ?></button>
    <a id="btn_set_password" id="" href="#responsive_<?=$id?>" data-toggle="modal" class="btn red-mint"> <?php echo __("Reset Password") ?>
        <i class="fa fa-key"></i>
    </a>
</td>
<td>
    <?php
    echo $this->Form->hidden('id', array(
        'class' => 'form-control',
        'label' => false,
        'value' => $id,
    ));
    ?>
    <?php
    echo $this->element('form/input', array(
        'field' => 'code',
        'label' => false,
    ));
    ?>
</td>
<td>
    <?php
    echo $this->element('form/input', array(
        'field' => 'name',
        'label' => false,
    ));
    ?>
</td>