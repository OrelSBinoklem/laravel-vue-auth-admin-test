const Welcome = () => import('~/pages/welcome').then(m => m.default || m)
const Login = () => import('~/pages/auth/login').then(m => m.default || m)
const Register = () => import('~/pages/auth/register').then(m => m.default || m)
const EmailSend = () => import('~/pages/auth/email/send').then(m => m.default || m)
const EmailVerify = () => import('~/pages/auth/email/verify').then(m => m.default || m)
const PasswordEmail = () => import('~/pages/auth/password/email').then(m => m.default || m)
const PasswordReset = () => import('~/pages/auth/password/reset').then(m => m.default || m)
const NotFound = () => import('~/pages/errors/404').then(m => m.default || m)

const Home = () => import('~/pages/home').then(m => m.default || m)
const Settings = () => import('~/pages/settings/index').then(m => m.default || m)
const SettingsProfile = () => import('~/pages/settings/profile').then(m => m.default || m)
const SettingsPassword = () => import('~/pages/settings/password').then(m => m.default || m)

const Admin = () => import('~/pages/admin/index').then(m => m.default || m)
const AdminUsers = () => import('~/pages/admin/users').then(m => m.default || m)
const AdminPermissions = () => import('~/pages/admin/permissions').then(m => m.default || m)
const AdminContent = () => import('~/pages/admin/content').then(m => m.default || m)

export default [
  { path: '/', name: 'welcome', component: Welcome },

  { path: '/login', name: 'login', component: Login },
  { path: '/register', name: 'register', component: Register },
  { path: '/email/send', name: 'email.resend', component: EmailSend },
  { path: '/email/verify/:id', name: 'email.verify', component: EmailVerify },
  { path: '/password/reset', name: 'password.request', component: PasswordEmail },
  { path: '/password/reset/:token', name: 'password.reset', component: PasswordReset },

  { path: '/home', name: 'home', component: Home },
  { path: '/settings',
    component: Settings,
    children: [
      { path: '', redirect: { name: 'settings.profile' } },
      { path: 'profile', name: 'settings.profile', component: SettingsProfile },
      { path: 'password', name: 'settings.password', component: SettingsPassword }
    ] },

  { path: '/admin', name: 'admin.dashboard', component: Admin },
  { path: '/admin/users', name: 'admin.users', component: AdminUsers },
  { path: '/admin/permissions', name: 'admin.permissions', component: AdminPermissions },
  { path: '/admin/content', name: 'admin.content', component: AdminContent },

  { path: '*', component: NotFound }
]
