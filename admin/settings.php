<?php include('includes/header.php'); ?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4>Website Settings</h4>
            </div>
            <div class="card-body">

                <?= alertMessage(); ?>

                <form action="code.php" method="POST">

                    <?php
                        $setting=getById('settings',1);
                    ?>
                    <input type="hidden" name="settingId" value="<?= $setting['data']['id'] ?? 'insert'?>" />

                    <h4 class="my-3">Contact Information</h4>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email1" value="<?= $setting['data']['email1'] ?? ""?>" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Phone</label>
                        <input type="text" name="phone1" value="<?= $setting['data']['phone1'] ?? ""?>" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Address</label>
                        <textarea name="address" class="form-control" rows="3"><?= $setting['data']['address'] ?? ""?></textarea>
                    </div>
                    <div class="mb-3 text-end">
                        <button type="submit" name="saveSetting" class="btn btn-primary">Save Setting</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
