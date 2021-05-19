
import ProfileComponent from '../../views/profile/profile';
import AccountSettingComponent from '../../views/profile/account-setting';
const ProfileRoutes = [
  {
    path: '/profile/:id',
    component: ProfileComponent,
  },
  {
    path: '/account-settings',
    component: AccountSettingComponent,
  }
];

export default ProfileRoutes;
