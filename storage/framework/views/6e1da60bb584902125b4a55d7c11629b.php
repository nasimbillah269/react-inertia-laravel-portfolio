<?php $__env->startSection('title'); ?><title><?php echo e(websiteTitle('Portfolio Settings')); ?></title><?php $__env->stopSection(); ?>
<?php $__env->startSection('contents'); ?>
<div class="content-header row">
    <div class="content-header-left col-12 mb-2">
        <h3 class="content-header-title mb-0">Portfolio Settings</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a></li>
            <li class="breadcrumb-item active">Portfolio Settings</li>
        </ol>
    </div>
</div>

<?php echo $__env->make(adminTheme().'alerts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php if($errors->any()): ?>
<div class="alert alert-danger"><ul class="mb-0"><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($e); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul></div>
<?php endif; ?>

<form method="POST" action="<?php echo e(route('admin.portfolio.settingsUpdate')); ?>" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group => $fields): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="card">
        <div class="card-header" style="background:#7c3aed;padding:12px 20px"><h4 class="mb-0" style="color:#fff"><?php echo e($group); ?></h4></div>
        <div class="card-body pt-2">
            <div class="row">
            <?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $def): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php ([$type, $label] = $def); ?>
                <div class="<?php echo e($type === 'textarea' ? 'col-12' : 'col-md-6'); ?> form-group">
                    <label for="<?php echo e($key); ?>"><?php echo e($label); ?></label>
                    <?php if($type === 'textarea'): ?>
                        <textarea name="<?php echo e($key); ?>" id="<?php echo e($key); ?>" rows="3" class="form-control"><?php echo e(old($key, $values[$key] ?? '')); ?></textarea>
                    <?php elseif($type === 'image' || $type === 'file'): ?>
                        <?php if(!empty($values[$key])): ?>
                            <div class="mb-1">
                                <?php if($type === 'image'): ?>
                                    <img src="<?php echo e(asset($values[$key])); ?>" style="max-height:90px;border-radius:6px;background:#1e1b4b;padding:4px">
                                <?php else: ?>
                                    <a href="<?php echo e(asset($values[$key])); ?>" target="_blank"><i class="fa fa-file"></i> Current file</a>
                                <?php endif; ?>
                                <label class="ml-1"><input type="checkbox" name="remove_<?php echo e($key); ?>" value="1"> Remove</label>
                            </div>
                        <?php endif; ?>
                        <input type="file" name="<?php echo e($key); ?>" id="<?php echo e($key); ?>" class="form-control" <?php if($type === 'image'): ?> accept="image/*" <?php endif; ?>>
                    <?php else: ?>
                        <input type="text" name="<?php echo e($key); ?>" id="<?php echo e($key); ?>" value="<?php echo e(old($key, $values[$key] ?? '')); ?>" class="form-control">
                    <?php endif; ?>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <button class="btn btn-success btn-lg mb-3"><i class="fa fa-save"></i> Save Settings</button>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make(adminTheme().'layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\nasim-portfolio\resources\views/admin/portfolio/settings.blade.php ENDPATH**/ ?>