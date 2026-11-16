<?php $__env->startSection('title'); ?><title><?php echo e(websiteTitle($s['title'])); ?></title><?php $__env->stopSection(); ?>
<?php $__env->startSection('contents'); ?>
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title mb-0"><?php echo e($s['title']); ?></h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a></li>
            <li class="breadcrumb-item active"><?php echo e($s['title']); ?></li>
        </ol>
    </div>
    <div class="content-header-right col-md-6 col-12 mb-2 text-md-right">
        <a class="btn btn-primary" href="<?php echo e(route('admin.portfolio.create', $s['key'])); ?>"><i class="fa fa-plus"></i> Add <?php echo e($s['singular']); ?></a>
    </div>
</div>

<?php echo $__env->make(adminTheme().'alerts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<div class="card">
    <div class="card-body">
        <form class="mb-2" action="<?php echo e(route('admin.portfolio.index', $s['key'])); ?>">
            <div class="input-group">
                <input type="text" name="search" value="<?php echo e(request('search')); ?>" class="form-control" placeholder="Search...">
                <button class="btn btn-success"><i class="fa fa-search"></i> Search</button>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th style="width:50px">#</th>
                        <?php $__currentLoopData = $s['columns']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><th><?php echo e($label); ?></th><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <th style="width:80px">Order</th>
                        <th style="width:90px">Status</th>
                        <th style="width:140px">Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($item->id); ?></td>
                        <?php $__currentLoopData = $s['columns']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $col => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <td>
                                <?php if(($s['fields'][$col]['type'] ?? '') === 'image'): ?>
                                    <?php if($item->$col): ?><img src="<?php echo e(asset($item->$col)); ?>" style="height:45px;max-width:80px;object-fit:cover;border-radius:4px"><?php else: ?> — <?php endif; ?>
                                <?php elseif(($s['fields'][$col]['type'] ?? '') === 'checkbox'): ?>
                                    <?php echo $item->$col ? '<span class="badge badge-success">Yes</span>' : '<span class="badge badge-secondary">No</span>'; ?>

                                <?php else: ?>
                                    <?php echo e(Str::limit(strip_tags((string) $item->$col), 70) ?: '—'); ?>

                                <?php endif; ?>
                            </td>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <td><?php echo e($item->sort_order); ?></td>
                        <td><?php echo $item->status ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>'; ?></td>
                        <td>
                            <a href="<?php echo e(route('admin.portfolio.edit', [$s['key'], $item->id])); ?>" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a>
                            <form action="<?php echo e(route('admin.portfolio.destroy', [$s['key'], $item->id])); ?>" method="POST" style="display:inline" onsubmit="return confirm('Delete this item?')">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="<?php echo e(count($s['columns']) + 4); ?>" class="text-center">No <?php echo e(strtolower($s['title'])); ?> found.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php echo e($items->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make(adminTheme().'layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\nasim-portfolio\resources\views/admin/portfolio/index.blade.php ENDPATH**/ ?>