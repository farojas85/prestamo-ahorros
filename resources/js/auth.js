export default class Auth {
    constructor(user){
        this.user = JSON.parse(user)
    }

    roles() {
        return this.user.roles.map(role => role.directriz);
    }

    hasRole($role) {
        return this.roles().includes($role);
    }

    permisos() {
        return this.user.permisos.map(permiso=>permiso.directriz);
    }

    menus() {
        return this.user.menus;
    }

    can($directrizPermiso) {
        return this.permisos().includes($directrizPermiso);
    }
}
