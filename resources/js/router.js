import UserComponent from "./components/Users/UserComponent.vue";
import UserCreateComponent from "./components/Users/UserCreateComponent.vue";
import LoginComponent from "./components/LoginComponent.vue";
import DashboardComponent from "./components/Dashboard/DashboardComponent.vue";
import ProductComponent from "./components/Products/ProductComponent.vue";
import ProductCreateComponent from "./components/Products/ProductCreateComponent.vue";
import OrderComponent from "./components/Orders/OrderComponent.vue";
import SiteComponent from "./components/Site/SiteComponent.vue";
import SettingComponent from "./components/Settings/SettingComponent.vue";
import UserEditComponent from "./components/Users/UserEditComponent.vue";
import ProductEditComponent from "./components/Products/ProductEditComponent.vue";
import RoleCreateComponent from "./components/Roles/RoleCreateComponent.vue";
import RoleEditComponent from "./components/Roles/RoleEditComponent.vue";


export const routes = [
    { path: '/login', component: LoginComponent, name: 'login' },
    { path: '/home', component: DashboardComponent, name: 'home' },
    { path: '/orders', component: OrderComponent, name: 'order' },
    { path: '/products', component: ProductComponent, name: 'product' },
    { path: '/products/create', component: ProductCreateComponent, name: 'product_create' },
    { path: '/products/:id/edit', component: ProductEditComponent, name: 'product_edit', props: true },
    { path: '/users', component: UserComponent, name: 'user' },
    { path: '/users/create', component: UserCreateComponent, name: 'user_create' },
    { path: '/user/:id/edit', component: UserEditComponent, name: 'user_edit', props: true},
    { path: '/site', component: SiteComponent, name: 'site' },
    { path: '/settings', component: SettingComponent, name: 'settings' },
    { path: '/role/create', component: RoleCreateComponent, name: 'role_create' },
    { path: '/role/:id/edit', component: RoleEditComponent, name: 'role_edit', props: true }
];
