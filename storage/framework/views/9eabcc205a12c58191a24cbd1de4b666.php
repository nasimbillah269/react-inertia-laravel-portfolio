<?php $__env->startSection('title'); ?><title><?php echo e(websiteTitle(($item->exists ? 'Edit ' : 'Add ') . $s['singular'])); ?></title><?php $__env->stopSection(); ?>
<?php $__env->startSection('contents'); ?>
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title mb-0"><?php echo e($item->exists ? 'Edit' : 'Add'); ?> <?php echo e($s['singular']); ?></h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?php echo e(route('admin.portfolio.index', $s['key'])); ?>"><?php echo e($s['title']); ?></a></li>
            <li class="breadcrumb-item active"><?php echo e($item->exists ? 'Edit' : 'Add'); ?></li>
        </ol>
    </div>
    <div class="content-header-right col-md-6 col-12 mb-2 text-md-right">
        <a class="btn btn-outline-primary" href="<?php echo e(route('admin.portfolio.index', $s['key'])); ?>"><i class="fa fa-arrow-left"></i> Back</a>
        <?php if($item->exists): ?>
        <a class="btn btn-primary" href="<?php echo e(route('admin.portfolio.create', $s['key'])); ?>"><i class="fa fa-plus"></i> Add New</a>
        <?php endif; ?>
    </div>
</div>

<?php echo $__env->make(adminTheme().'alerts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php if($errors->any()): ?>
<div class="alert alert-danger"><ul class="mb-0"><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($e); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul></div>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data"
      action="<?php echo e($item->exists ? route('admin.portfolio.update', [$s['key'], $item->id]) : route('admin.portfolio.store', $s['key'])); ?>">
    <?php echo csrf_field(); ?>
    <?php if($item->exists): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>
    <div class="row">
        <div class="col-md-8">
            <div class="card"><div class="card-body">
            <?php $__currentLoopData = $s['fields']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name => $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($f['type'] === 'image' || $f['type'] === 'checkbox'): ?> <?php continue; ?> <?php endif; ?>
                <div class="form-group">
                    <label for="<?php echo e($name); ?>"><?php echo e($f['label']); ?> <?php if(str_contains($f['rules'] ?? '', 'required')): ?><span class="text-danger">*</span><?php endif; ?></label>
                    <?php switch($f['type']):
                        case ('textarea'): ?>
                            <textarea name="<?php echo e($name); ?>" id="<?php echo e($name); ?>" rows="4" class="form-control"><?php echo e(old($name, $item->$name)); ?></textarea>
                            <?php break; ?>
                        <?php case ('editor'): ?>
                            <textarea name="<?php echo e($name); ?>" id="<?php echo e($name); ?>" class="form-control tinyEditor"><?php echo e(old($name, $item->$name)); ?></textarea>
                            <?php break; ?>
                        <?php case ('select'): ?>
                            <select name="<?php echo e($name); ?>" id="<?php echo e($name); ?>" class="form-control">
                                <?php if(!str_contains($f['rules'] ?? '', 'required')): ?><option value="">— None —</option><?php endif; ?>
                                <?php $__currentLoopData = $f['options']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $lbl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($val); ?>" <?php if(old($name, $item->$name) == $val): echo 'selected'; endif; ?>><?php echo e(ucfirst($lbl)); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php break; ?>
                        <?php case ('number'): ?>
                            <input type="number" name="<?php echo e($name); ?>" id="<?php echo e($name); ?>" value="<?php echo e(old($name, $item->$name)); ?>" class="form-control">
                            <?php break; ?>
                        <?php case ('color'): ?>
                            <input type="color" name="<?php echo e($name); ?>" id="<?php echo e($name); ?>" value="<?php echo e(old($name, $item->$name ?: '#8b5cf6')); ?>" class="form-control" style="height:42px;max-width:120px">
                            <?php break; ?>
                        <?php default: ?>
                            <input type="text" name="<?php echo e($name); ?>" id="<?php echo e($name); ?>" value="<?php echo e(old($name, $item->$name)); ?>" class="form-control">
                    <?php endswitch; ?>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div></div>
        </div>
        <div class="col-md-4">
            <div class="card"><div class="card-body">
                <?php $__currentLoopData = $s['fields']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name => $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($f['type'] === 'image'): ?>
                    <div class="form-group">
                        <label><?php echo e($f['label']); ?></label>
                        <?php if($item->$name): ?>
                            <div class="mb-1"><img src="<?php echo e(asset($item->$name)); ?>" style="max-width:100%;max-height:160px;border-radius:6px"></div>
                            <label class="d-block"><input type="checkbox" name="remove_<?php echo e($name); ?>" value="1"> Remove image</label>
                        <?php endif; ?>
                        <input type="file" name="<?php echo e($name); ?>" accept="image/*" class="form-control">
                    </div>
                    <?php elseif($f['type'] === 'checkbox'): ?>
                    <div class="form-group">
                        <label><input type="checkbox" name="<?php echo e($name); ?>" value="1" <?php if(old($name, $item->$name)): echo 'checked'; endif; ?>> <?php echo e($f['label']); ?></label>
                    </div>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <div class="form-group">
                    <label>Sort Order <small>(smaller shows first)</small></label>
                    <input type="number" name="sort_order" value="<?php echo e(old('sort_order', $item->sort_order ?? 0)); ?>" class="form-control">
                </div>
                <div class="form-group">
                    <label><input type="checkbox" name="status" value="1" <?php if(old('status', $item->status)): echo 'checked'; endif; ?>> Active</label>
                </div>
                <button class="btn btn-success btn-block"><i class="fa fa-save"></i> Save</button>
            </div></div>
        </div>
    </div>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make(adminTheme().'layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\nasim-portfolio\resources\views/admin/portfolio/form.blade.php ENDPATH**/ ?>