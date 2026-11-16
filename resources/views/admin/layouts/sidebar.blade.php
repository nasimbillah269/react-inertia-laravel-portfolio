 <!-- BEGIN: Main Menu-->
   <div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
     <div class="main-menu-content">
       <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
         <li class=" navigation-header"><span>General</span><i class="feather icon-minus"></i></li>
         <li class="nav-item {{ Request::is('admin/dashboard') ? 'active' : '' }}">
           <a href="{{ route('admin.dashboard') }}"><i class="fas fa-th-large"></i><span class="menu-title">Dashboard</span></a>
         </li>
         <li class="nav-item {{ Request::is('admin/my-profile') ? 'active' : '' }}">
           <a href="{{ route('admin.myProfile') }}"><i class="fas fa-user-check"></i><span class="menu-title">My Profile</span></a>
         </li>

         <li class=" navigation-header"><span style="color:#7c3aed;font-weight:bold;">Portfolio</span><i class="feather icon-minus"></i></li>
         <li class="nav-item {{ Request::is('admin/portfolio/settings*') ? 'active' : '' }}">
           <a href="{{ route('admin.portfolio.settings') }}"><i class="fas fa-user-astronaut"></i><span class="menu-title">Hero, About & Settings</span></a>
         </li>
         @foreach([
            'skills' => ['fas fa-code', 'Skills'],
            'services' => ['fas fa-concierge-bell', 'Services'],
            'projects' => ['fas fa-briefcase', 'Projects'],
            'testimonials' => ['fas fa-comment-dots', 'Testimonials'],
            'achievements' => ['fas fa-trophy', 'Facts & Numbers'],
         ] as $key => [$icon, $label])
         <li class="nav-item {{ Request::is('admin/portfolio/'.$key.'*') ? 'active' : '' }}">
           <a href="{{ route('admin.portfolio.index', $key) }}"><i class="{{ $icon }}"></i><span class="menu-title">{{ $label }}</span></a>
         </li>
         @endforeach
         <li class="nav-item {{ Request::is('admin/portfolio/messages*') ? 'active' : '' }}">
           <a href="{{ route('admin.portfolio.messages') }}"><i class="fas fa-envelope"></i><span class="menu-title">Messages</span>
             @php($unreadMsg = \App\Models\ContactMessage::where('is_read', false)->count())
             @if($unreadMsg)<span class="badge badge-pill badge-danger float-right mr-2">{{ $unreadMsg }}</span>@endif
           </a>
         </li>

         <li class=" navigation-header"><span>Blog</span><i class="feather icon-minus"></i></li>
         <li class="nav-item {{ Request::is('admin/posts*') ? 'active' : '' }}">
           <a href="#"><i class="fas fa-file-alt"></i><span class="menu-title">Blog Posts</span></a>
           <ul class="menu-content">
             <li class="{{ Request::is('admin/posts') ? 'active' : '' }}"><a class="menu-item" href="{{ route('admin.posts') }}">All Posts</a></li>
             <li><a class="menu-item" href="{{ route('admin.postsAction', ['create']) }}">New Post</a></li>
             <li class="{{ Request::is('admin/posts/categories*') ? 'active' : '' }}"><a class="menu-item" href="{{ route('admin.postsCategories') }}">Categories</a></li>
             <li class="{{ Request::is('admin/posts/tags*') ? 'active' : '' }}"><a class="menu-item" href="{{ route('admin.postsTags') }}">Tags</a></li>
             <li class="{{ Request::is('admin/posts/comments*') ? 'active' : '' }}"><a class="menu-item" href="{{ route('admin.postsCommentsAll') }}">Comments</a></li>
           </ul>
         </li>
         <li class="nav-item {{ Request::is('admin/medi*') ? 'active' : '' }}">
           <a href="{{ route('admin.medies') }}"><i class="fas fa-images"></i><span class="menu-title">Media Library</span></a>
         </li>

         <li class=" navigation-header"><span>System</span><i class="feather icon-minus"></i></li>
         <li class="nav-item {{ Request::is('admin/users*') ? 'active' : '' }}">
           <a href="#"><i class="fas fa-users"></i><span class="menu-title">Admin Users</span></a>
           <ul class="menu-content">
             <li class="{{ Request::is('admin/users/admin*') ? 'active' : '' }}"><a class="menu-item" href="{{ route('admin.usersAdmin') }}">Administrators</a></li>
             <li class="{{ Request::is('admin/users/role*') ? 'active' : '' }}"><a class="menu-item" href="{{ route('admin.userRoles') }}">Roles</a></li>
           </ul>
         </li>
         <li class="nav-item {{ Request::is('admin/setting*') ? 'active' : '' }}">
           <a href="#"><i class="fa fa-cog"></i><span class="menu-title">App Settings</span></a>
           <ul class="menu-content">
             <li class="{{ Request::is('admin/setting/general*') ? 'active' : '' }}"><a class="menu-item" href="{{ route('admin.setting', 'general') }}">General (logo, favicon)</a></li>
             <li class="{{ Request::is('admin/setting/mail*') ? 'active' : '' }}"><a class="menu-item" href="{{ route('admin.setting', 'mail') }}">Mail Setting</a></li>
           </ul>
         </li>
       </ul>
     </div>
   </div>
