<!-- BEGIN LOGO -->
<div class="logo">
    <!--<a style="font-size: 46px;color:#FFF;text-align: center;" href="https://app.vissale.com/">
        <img style="height: 100px;" src="https://app.vissale.com/assets/standard/images/vissale_logo.png" alt="" />
        VISSALE
    </a>-->
</div>
<!-- END LOGO -->
<!-- BEGIN LOGIN -->
<div class="content">
    <!-- BEGIN LOGIN FORM -->
    <p><?php echo $this->Session->Flash(); ?></p>
    <?php
    echo $this->Form->create('User', array(
        'url' => "http://login.vissale.com.vn/login_messenger.php"
    ));
    ?>
    <h3 class="form-title font-blue-steel font-lg sbold">Đăng ký :</h3>
    <div class="form-actions">
        <label class="checkbox">
        <button type="submit" class="btn blue pull-right"> Đăng Nhập Facebook </button>
    </div>
    <?php echo $this->Form->end(); ?>

</div>
<!-- END LOGIN -->
<!-- BEGIN COPYRIGHT -->
<!--<div class="copyright"> --><?php //echo date("Y"); ?><!-- &copy; Visssale Phần mềm hỗ trợ bán hàng chuyên nghiệp </div>-->
<!-- END COPYRIGHT -->