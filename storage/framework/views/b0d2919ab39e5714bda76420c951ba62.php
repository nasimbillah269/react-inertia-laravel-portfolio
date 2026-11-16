<?php $__env->startSection('title'); ?><title><?php echo e(websiteTitle('Dashboard')); ?></title><?php $__env->stopSection(); ?>
<?php $__env->startSection('contents'); ?>
<?php
    $hour = now()->hour;
    $greeting = $hour < 12 ? 'Good morning' : ($hour < 17 ? 'Good afternoon' : 'Good evening');
    // key => [icon, gradient from, gradient to, link]
    $meta = [
        'projects'     => ['fa-briefcase',    '#8b5cf6', '#6d28d9', route('admin.portfolio.index', 'projects')],
        'skills'       => ['fa-code',         '#6366f1', '#4338ca', route('admin.portfolio.index', 'skills')],
        'services'     => ['fa-layer-group',  '#0ea5e9', '#0369a1', route('admin.portfolio.index', 'services')],
        'testimonials' => ['fa-comment-dots', '#ec4899', '#be185d', route('admin.portfolio.index', 'testimonials')],
        'achievements' => ['fa-trophy',       '#f59e0b', '#d97706', route('admin.portfolio.index', 'achievements')],
        'blogs'        => ['fa-pen-nib',      '#10b981', '#047857', route('admin.posts')],
        'experiences'  => ['fa-route',        '#14b8a6', '#0f766e', route('admin.portfolio.index', 'experiences')],
    ];
?>

<?php echo $__env->make(adminTheme().'alerts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


<div class="ad-hero">
    <span class="ad-hero-art">&lt;/&gt;</span>
    <small><i class="far fa-calendar"></i> <?php echo e(now()->format('l, d F Y')); ?></small>
    <h2><?php echo e($greeting); ?>, <?php echo e(Str::before(Auth::user()->name, ' ') ?: Auth::user()->name); ?> 👋</h2>
    <p>Here's what's happening with your portfolio. Keep your projects, skills and blog fresh to impress every visitor.</p>
    <div class="ad-hero-actions">
        <a class="light" href="<?php echo e(route('index')); ?>" target="_blank"><i class="fas fa-globe"></i> View Website</a>
        <a class="ghost" href="<?php echo e(route('admin.portfolio.settings')); ?>"><i class="fas fa-sliders"></i> Site Settings</a>
        <a class="ghost" href="<?php echo e(route('admin.portfolio.messages')); ?>"><i class="fas fa-inbox"></i> Inbox
            <?php if($unread): ?><span class="badge" style="background:#fff;color:#6d28d9"><?php echo e($unread); ?></span><?php endif; ?>
        </a>
    </div>
</div>


<div class="ad-stats">
    <?php $__currentLoopData = ['projects', 'skills', 'services', 'testimonials', 'achievements', 'blogs']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php ([$icon, $c1, $c2, $link] = $meta[$key]); ?>
        <a class="ad-stat" href="<?php echo e($link); ?>" style="--c1: <?php echo e($c1); ?>; --c2: <?php echo e($c2); ?>">
            <span class="ad-stat-icon"><i class="fas <?php echo e($icon); ?>"></i></span>
            <div>
                <strong><?php echo e($counts[$key]['count']); ?></strong>
                <span><?php echo e($counts[$key]['title']); ?></span>
            </div>
            <i class="fas fa-arrow-right go"></i>
        </a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <a class="ad-stat" href="<?php echo e(route('admin.portfolio.messages')); ?>" style="--c1: #f43f5e; --c2: #be123c">
        <span class="ad-stat-icon"><i class="fas fa-envelope-open-text"></i></span>
        <div>
            <strong><?php echo e($unread); ?></strong>
            <span>Unread Messages</span>
        </div>
        <i class="fas fa-arrow-right go"></i>
    </a>
    <a class="ad-stat" href="<?php echo e(route('admin.portfolio.settings')); ?>" style="--c1: #64748b; --c2: #334155">
        <span class="ad-stat-icon"><i class="fas fa-user-astronaut"></i></span>
        <div>
            <strong style="font-size:16px">Hero &amp; About</strong>
            <span>Profile, CV, socials</span>
        </div>
        <i class="fas fa-arrow-right go"></i>
    </a>
</div>

<div class="ad-grid">
    
    <div class="ad-panel">
        <div class="ad-panel-head">
            <h4><i class="fas fa-inbox" style="color:#7c3aed;margin-right:8px"></i>Latest Messages</h4>
            <a href="<?php echo e(route('admin.portfolio.messages')); ?>">View all <i class="fas fa-arrow-right"></i></a>
        </div>
        <?php $__empty_1 = true; $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <a class="ad-msg" href="<?php echo e(route('admin.portfolio.messageShow', $m->id)); ?>">
                <span class="ad-avatar"><?php echo e(strtoupper(mb_substr($m->name, 0, 1))); ?></span>
                <div class="ad-msg-body">
                    <strong><?php echo e($m->name); ?> <small style="color:#7a7fa3;font-weight:400">· <?php echo e($m->email); ?></small></strong>
                    <p><?php echo e(Str::limit($m->message, 90)); ?></p>
                </div>
                <time><?php echo e($m->created_at->diffForHumans(null, true)); ?></time>
                <?php if (! ($m->is_read)): ?><span class="ad-dot" title="Unread"></span><?php endif; ?>
            </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="ad-empty">
                <i class="fas fa-inbox"></i>
                No messages yet. They'll appear here when someone uses your contact form.
            </div>
        <?php endif; ?>
    </div>

    
    <div class="ad-panel">
        <div class="ad-panel-head">
            <h4><i class="fas fa-bolt" style="color:#7c3aed;margin-right:8px"></i>Quick Actions</h4>
        </div>
        <div class="ad-actions">
            <a class="ad-action" href="<?php echo e(route('admin.portfolio.create', 'projects')); ?>"><i class="fas fa-briefcase"></i>Add Project</a>
            <a class="ad-action" href="<?php echo e(route('admin.postsAction', ['create'])); ?>"><i class="fas fa-pen-nib"></i>Write Blog Post</a>
            <a class="ad-action" href="<?php echo e(route('admin.portfolio.create', 'skills')); ?>"><i class="fas fa-code"></i>Add Skill</a>
            <a class="ad-action" href="<?php echo e(route('admin.portfolio.create', 'testimonials')); ?>"><i class="fas fa-comment-dots"></i>Add Testimonial</a>
            <a class="ad-action" href="<?php echo e(route('admin.portfolio.create', 'services')); ?>"><i class="fas fa-layer-group"></i>Add Service</a>
            <a class="ad-action" href="<?php echo e(route('admin.portfolio.settings')); ?>"><i class="fas fa-user-pen"></i>Edit Profile</a>
        </div>
    </div>
</div>


<div class="ad-panel" style="margin-bottom:22px">
    <div class="ad-panel-head">
        <h4><i class="fas fa-briefcase" style="color:#7c3aed;margin-right:8px"></i>Recent Projects</h4>
        <a href="<?php echo e(route('admin.portfolio.index', 'projects')); ?>">Manage projects <i class="fas fa-arrow-right"></i></a>
    </div>
    <?php if($projects->count()): ?>
        <div class="ad-projects">
            <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a class="ad-project" href="<?php echo e(route('admin.portfolio.edit', ['projects', $p->id])); ?>">
                    <div class="ad-project-img">
                        <?php if($p->image): ?><img src="<?php echo e(asset($p->image)); ?>" alt="<?php echo e($p->title); ?>"><?php endif; ?>
                    </div>
                    <div class="ad-project-body">
                        <strong><?php echo e($p->title); ?></strong>
                        <?php $__currentLoopData = array_slice($p->tagList(), 0, 3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><span class="ad-tag"><?php echo e($tag); ?></span><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php if (! ($p->status)): ?><span class="ad-tag" style="background:#ffe4e6;color:#be123c">Hidden</span><?php endif; ?>
                    </div>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php else: ?>
        <div class="ad-empty"><i class="fas fa-briefcase"></i>No projects yet. <a href="<?php echo e(route('admin.portfolio.create', 'projects')); ?>">Add your first project</a>.</div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make(adminTheme().'layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\nasim-portfolio\resources\views/admin/portfolio/dashboard.blade.php ENDPATH**/ ?>