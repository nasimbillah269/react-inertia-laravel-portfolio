<?php $__env->startSection('title'); ?><title><?php echo e(websiteTitle('Contact Messages')); ?></title><?php $__env->stopSection(); ?>
<?php $__env->startSection('contents'); ?>
<div class="content-header row">
    <div class="content-header-left col-12 mb-2">
        <h3 class="content-header-title mb-0">Contact Messages</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a></li>
            <li class="breadcrumb-item active">Messages</li>
        </ol>
    </div>
</div>
<?php echo $__env->make(adminTheme().'alerts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="card"><div class="card-body">
    <form class="mb-2" action="<?php echo e(route('admin.portfolio.messages')); ?>">
        <div class="input-group">
            <input type="text" name="search" value="<?php echo e(request('search')); ?>" class="form-control" placeholder="Name or email">
            <button class="btn btn-success"><i class="fa fa-search"></i> Search</button>
        </div>
    </form>
    <div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead><tr><th>Name</th><th>Email</th><th>Message</th><th>Date</th><th style="width:110px">Action</th></tr></thead>
        <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr style="<?php echo e($m->is_read ? '' : 'font-weight:bold'); ?>">
                <td><?php echo e($m->name); ?> <?php if (! ($m->is_read)): ?><span class="badge badge-primary">New</span><?php endif; ?></td>
                <td><?php echo e($m->email); ?></td>
                <td><?php echo e(Str::limit($m->message, 80)); ?></td>
                <td><?php echo e($m->created_at->format('d M Y, h:i A')); ?></td>
                <td>
                    <a href="<?php echo e(route('admin.portfolio.messageShow', $m->id)); ?>" class="btn btn-sm btn-info"><i class="fa fa-eye"></i></a>
                    <form action="<?php echo e(route('admin.portfolio.messageDelete', $m->id)); ?>" method="POST" style="display:inline" onsubmit="return confirm('Delete?')">
                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                        <button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                    </form>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="5" class="text-center">No messages yet.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
    </div>
    <?php echo e($items->links()); ?>

</div></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make(adminTheme().'layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\nasim-portfolio\resources\views/admin/portfolio/messages.blade.php ENDPATH**/ ?>