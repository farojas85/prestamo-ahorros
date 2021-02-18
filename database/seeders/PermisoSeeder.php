<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permiso;

class PermisoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role1 = Role::select('id')->where('directriz','super-usuario')->first();
        // 'nombre','directriz','descripcion'
        $permiso1 = Permiso::firstOrCreate([
            'nombre' => 'Vista Rol','directriz' => 'roles.inicio','descripcion' => 'Vista Inicio Rol.'
        ])
        ;
        $permiso2 = Permiso::firstOrCreate([
            'nombre' => 'Crear Rol','directriz' => 'roles.crear','descripcion' => 'Añadir Nuevo Rol.'
        ])
        ;
        $permiso3 = Permiso::firstOrCreate([
            'nombre' => 'Editar Rol','directriz' => 'roles.editar','descripcion' => 'Editar Datos de Rol Seleccionado.'
        ])
        ;
        $permiso4 = Permiso::firstOrCreate([
            'nombre' => 'Eliminar Rol','directriz' => 'roles.eliminar','descripcion' => 'Eliminar Registro de Rol Seleccionado.'
        ])
        ;
        $permiso5 = Permiso::firstOrCreate([
            'nombre' => 'Restaurar Rol','directriz' => 'roles.restaurar','descripcion' => 'Restaurar Registro de Rol Seleccionado.'
        ])
        ;

        $permiso6 = Permiso::firstOrCreate([
            'nombre' => 'Vista Usuario','directriz' => 'usuarios.inicio','descripcion' => 'Vista Inicio Usuario.'
        ])
        ;
        $permiso7 = Permiso::firstOrCreate([
            'nombre' => 'Crear Usuario','directriz' => 'usuarios.crear','descripcion' => 'Añadir Nuevo Usuario.'
        ])
        ;
        $permiso8 = Permiso::firstOrCreate([
            'nombre' => 'Editar Usuario','directriz' => 'usuarios.editar','descripcion' => 'Editar Datos de Usuario Seleccionado.'
        ])
        ;
        $permiso9 = Permiso::firstOrCreate([
            'nombre' => 'Eliminar Usuario','directriz' => 'usuarios.eliminar','descripcion' => 'Eliminar Registro de Usuario Seleccionado.'
        ])
        ;
        $permiso10 = Permiso::firstOrCreate([
            'nombre' => 'Restaurar Usuario','directriz' => 'usuarios.restaurar','descripcion' => 'Restaurar Registro de Usuario Seleccionado.'
        ])
        ;

        $permiso11 = Permiso::firstOrCreate([
            'nombre' => 'Vista Permiso','directriz' => 'permisos.inicio','descripcion' => 'Vista Inicio Permiso.'
        ])
        ;
        $permiso12 = Permiso::firstOrCreate([
            'nombre' => 'Crear Permiso','directriz' => 'permisos.crear','descripcion' => 'Añadir Nuevo Permiso.'
        ])
        ;
        $permiso13 = Permiso::firstOrCreate([
            'nombre' => 'Editar Permiso','directriz' => 'permisos.editar','descripcion' => 'Editar Datos de Permiso Seleccionado.'
        ])
        ;
        $permiso14 = Permiso::firstOrCreate([
            'nombre' => 'Eliminar Permiso','directriz' => 'permisos.eliminar','descripcion' => 'Eliminar Registro de Permiso Seleccionado.'
        ])
        ;
        $permiso15 = Permiso::firstOrCreate([
            'nombre' => 'Restaurar Permiso','directriz' => 'permisos.restaurar','descripcion' => 'Restaurar Registro de Permiso Seleccionado.'
        ])
        ;

        $permiso16 = Permiso::firstOrCreate([
            'nombre' => 'Vista Permiso/Role','directriz' => 'permiso-role.inicio','descripcion' => 'Vista Inicio Permiso/Role.'
        ])
        ;
        $permiso17 = Permiso::firstOrCreate([
            'nombre' => 'Guardar Permiso/Role','directriz' => 'permiso-role.guardar','descripcion' => 'Añadir Nuevo Permiso/Role.'
        ])
        ;

        $permiso18 = Permiso::firstOrCreate([
            'nombre' => 'Vista Menú','directriz' => 'menus.inicio','descripcion' => 'Vista Inicio Menú.'
        ])
        ;
        $permiso19 = Permiso::firstOrCreate([
            'nombre' => 'Crear Menú','directriz' => 'menus.crear','descripcion' => 'Añadir Nuevo Menú.'
        ])
        ;
        $permiso20 = Permiso::firstOrCreate([
            'nombre' => 'Editar Menú','directriz' => 'menus.editar','descripcion' => 'Editar Datos de Menú Seleccionado.'
        ])
        ;
        $permiso21 = Permiso::firstOrCreate([
            'nombre' => 'Eliminar Menú','directriz' => 'menus.eliminar','descripcion' => 'Eliminar Registro de Menú Seleccionado.'
        ])
        ;
        $permiso22 = Permiso::firstOrCreate([
            'nombre' => 'Restaurar Menú','directriz' => 'menus.restaurar','descripcion' => 'Restaurar Registro de Menú Seleccionado.'
        ])
        ;

        $permiso23 = Permiso::firstOrCreate([
            'nombre' => 'Vista Menú/Roles','directriz' => 'menu-role.inicio','descripcion' => 'Vista Inicio Menú/Roles.'
        ])
        ;
        $permiso24 = Permiso::firstOrCreate([
            'nombre' => 'Guardar Menú/Roles','directriz' => 'menu-role.guardar','descripcion' => 'Guardar Menú/Roles.'
        ])
        ;

        $permiso25 = Permiso::firstOrCreate([
            'nombre' => 'Vista Tipo DOcumento','directriz' => 'tipo-documentos.inicio','descripcion' => 'Vista Inicio Tipo DOcumento.'
        ])
        ;
        $permiso26 = Permiso::firstOrCreate([
            'nombre' => 'Crear Tipo DOcumento','directriz' => 'tipo-documentos.crear','descripcion' => 'Añadir Nuevo Tipo DOcumento.'
        ])
        ;
        $permiso27 = Permiso::firstOrCreate([
            'nombre' => 'Editar Tipo DOcumento','directriz' => 'tipo-documentos.editar','descripcion' => 'Editar Datos de Tipo DOcumento Seleccionado.'
        ])
        ;
        $permiso28 = Permiso::firstOrCreate([
            'nombre' => 'Eliminar Tipo DOcumento','directriz' => 'tipo-documentos.eliminar','descripcion' => 'Eliminar Registro de Tipo DOcumento Seleccionado.'
        ])
        ;
        $permiso29 = Permiso::firstOrCreate([
            'nombre' => 'Restaurar Tipo DOcumento','directriz' => 'tipo-documentos.restaurar','descripcion' => 'Restaurar Registro de Tipo DOcumento Seleccionado.'
        ])
        ;

        $permiso30 = Permiso::firstOrCreate([
            'nombre' => 'Vista Tipo Documento','directriz' => 'tipo-movimientos.inicio','descripcion' => 'Vista Inicio Tipo Documento.'
        ])
        ;
        $permiso31 = Permiso::firstOrCreate([
            'nombre' => 'Crear Tipo Documento','directriz' => 'tipo-movimientos.crear','descripcion' => 'Añadir Nuevo Tipo Documento.'
        ])
        ;
        $permiso32 = Permiso::firstOrCreate([
            'nombre' => 'Editar Tipo Documento','directriz' => 'tipo-movimientos.editar','descripcion' => 'Editar Datos de Tipo Documento Seleccionado.'
        ])
        ;
        $permiso33 = Permiso::firstOrCreate([
            'nombre' => 'Eliminar Tipo Documento','directriz' => 'tipo-movimientos.eliminar','descripcion' => 'Eliminar Registro de Tipo Documento Seleccionado.'
        ])
        ;
        $permiso34 = Permiso::firstOrCreate([
            'nombre' => 'Restaurar Tipo Documento','directriz' => 'tipo-movimientos.restaurar','descripcion' => 'Restaurar Registro de Tipo Documento Seleccionado.'
        ])
        ;

        $permiso35 = Permiso::firstOrCreate([
            'nombre' => 'Vista Tipo Cuota','directriz' => 'tipo-cuotas.inicio','descripcion' => 'Vista Inicio Tipo Cuota.'
        ])
        ;
        $permiso36 = Permiso::firstOrCreate([
            'nombre' => 'Crear Tipo Cuota','directriz' => 'tipo-cuotas.crear','descripcion' => 'Añadir Nuevo Tipo Cuota.'
        ])
        ;
        $permiso37 = Permiso::firstOrCreate([
            'nombre' => 'Editar Tipo Cuota','directriz' => 'tipo-cuotas.editar','descripcion' => 'Editar Datos de Tipo Cuota Seleccionado.'
        ])
        ;
        $permiso38 = Permiso::firstOrCreate([
            'nombre' => 'Eliminar Tipo Cuota','directriz' => 'tipo-cuotas.eliminar','descripcion' => 'Eliminar Registro de Tipo Cuota Seleccionado.'
        ])
        ;
        $permiso39 = Permiso::firstOrCreate([
            'nombre' => 'Restaurar Tipo Cuota','directriz' => 'tipo-cuotas.restaurar','descripcion' => 'Restaurar Registro de Tipo Cuota Seleccionado.'
        ])
        ;

        $permiso40 = Permiso::firstOrCreate([
            'nombre' => 'Vista Tasa Interés','directriz' => 'tasa-intereses.inicio','descripcion' => 'Vista Inicio Tasa Interés.'
        ])
        ;
        $permiso41 = Permiso::firstOrCreate([
            'nombre' => 'Crear Tasa Interés','directriz' => 'tasa-intereses.crear','descripcion' => 'Añadir Nuevo Tasa Interés.'
        ])
        ;
        $permiso42 = Permiso::firstOrCreate([
            'nombre' => 'Editar Tasa Interés','directriz' => 'tasa-intereses.editar','descripcion' => 'Editar Datos de Tasa Interés Seleccionado.'
        ])
        ;
        $permiso43 = Permiso::firstOrCreate([
            'nombre' => 'Eliminar Tasa Interés','directriz' => 'tasa-intereses.eliminar','descripcion' => 'Eliminar Registro de Tasa Interés Seleccionado.'
        ])
        ;
        $permiso44 = Permiso::firstOrCreate([
            'nombre' => 'Restaurar Tasa Interés','directriz' => 'tasa-intereses.restaurar','descripcion' => 'Restaurar Registro de Tasa Interés Seleccionado.'
        ])
        ;

        $permiso45 = Permiso::firstOrCreate([
            'nombre' => 'Vista Tasa Interés','directriz' => 'valoraciones.inicio','descripcion' => 'Vista Inicio Tasa Interés.'
        ])
        ;
        $permiso46 = Permiso::firstOrCreate([
            'nombre' => 'Crear Tasa Interés','directriz' => 'valoraciones.crear','descripcion' => 'Añadir Nuevo Tasa Interés.'
        ])
        ;
        $permiso47 = Permiso::firstOrCreate([
            'nombre' => 'Editar Tasa Interés','directriz' => 'valoraciones.editar','descripcion' => 'Editar Datos de Tasa Interés Seleccionado.'
        ])
        ;
        $permiso48 = Permiso::firstOrCreate([
            'nombre' => 'Eliminar Tasa Interés','directriz' => 'valoraciones.eliminar','descripcion' => 'Eliminar Registro de Tasa Interés Seleccionado.'
        ])
        ;
        $permiso49 = Permiso::firstOrCreate([
            'nombre' => 'Restaurar Tasa Interés','directriz' => 'valoraciones.restaurar','descripcion' => 'Restaurar Registro de Tasa Interés Seleccionado.'
        ])
        ;

        $permiso50 = Permiso::firstOrCreate([
            'nombre' => 'Vista Moneda','directriz' => 'monedas.inicio','descripcion' => 'Vista Inicio Moneda.'
        ])
        ;
        $permiso51 = Permiso::firstOrCreate([
            'nombre' => 'Crear Moneda','directriz' => 'monedas.crear','descripcion' => 'Añadir Nuevo Moneda.'
        ])
        ;
        $permiso52 = Permiso::firstOrCreate([
            'nombre' => 'Editar Moneda','directriz' => 'monedas.editar','descripcion' => 'Editar Datos de Moneda Seleccionado.'
        ])
        ;
        $permiso53 = Permiso::firstOrCreate([
            'nombre' => 'Eliminar Moneda','directriz' => 'monedas.eliminar','descripcion' => 'Eliminar Registro de Moneda Seleccionado.'
        ])
        ;
        $permiso54 = Permiso::firstOrCreate([
            'nombre' => 'Restaurar Moneda','directriz' => 'monedas.restaurar','descripcion' => 'Restaurar Registro de Moneda Seleccionado.'
        ])
        ;

        $permiso55 = Permiso::firstOrCreate([
            'nombre' => 'Vista Entidad Financiera','directriz' => 'entidad-financieras.inicio','descripcion' => 'Vista Inicio Entidad Financiera.'
        ])
        ;
        $permiso56 = Permiso::firstOrCreate([
            'nombre' => 'Crear Entidad Financiera','directriz' => 'entidad-financieras.crear','descripcion' => 'Añadir Nuevo Entidad Financiera.'
        ])
        ;
        $permiso57 = Permiso::firstOrCreate([
            'nombre' => 'Editar Entidad Financiera','directriz' => 'entidad-financieras.editar','descripcion' => 'Editar Datos de Entidad Financiera Seleccionado.'
        ])
        ;
        $permiso58 = Permiso::firstOrCreate([
            'nombre' => 'Eliminar Entidad Financiera','directriz' => 'entidad-financieras.eliminar','descripcion' => 'Eliminar Registro de Entidad Financiera Seleccionado.'
        ])
        ;
        $permiso59 = Permiso::firstOrCreate([
            'nombre' => 'Restaurar Entidad Financiera','directriz' => 'entidad-financieras.restaurar','descripcion' => 'Restaurar Registro de Entidad Financiera Seleccionado.'
        ])
        ;

        $permiso60 = Permiso::firstOrCreate([
            'nombre' => 'Vista Medio Pago','directriz' => 'medio-pagos.inicio','descripcion' => 'Vista Inicio Medio Pago.'
        ])
        ;
        $permiso61 = Permiso::firstOrCreate([
            'nombre' => 'Crear Medio Pago','directriz' => 'medio-pagos.crear','descripcion' => 'Añadir Nuevo Medio Pago.'
        ])
        ;
        $permiso62 = Permiso::firstOrCreate([
            'nombre' => 'Editar Medio Pago','directriz' => 'medio-pagos.editar','descripcion' => 'Editar Datos de Medio Pago Seleccionado.'
        ])
        ;
        $permiso63 = Permiso::firstOrCreate([
            'nombre' => 'Eliminar Medio Pago','directriz' => 'medio-pagos.eliminar','descripcion' => 'Eliminar Registro de Medio Pago Seleccionado.'
        ])
        ;
        $permiso64 = Permiso::firstOrCreate([
            'nombre' => 'Restaurar Medio Pago','directriz' => 'medio-pagos.restaurar','descripcion' => 'Restaurar Registro de Medio Pago Seleccionado.'
        ])
        ;

        $permiso65 = Permiso::firstOrCreate([
            'nombre' => 'Vista Préstamo','directriz' => 'prestamos.inicio','descripcion' => 'Vista Inicio Préstamo.'
        ])
        ;
        $permiso66 = Permiso::firstOrCreate([
            'nombre' => 'Crear Préstamo','directriz' => 'prestamos.crear','descripcion' => 'Añadir Nuevo Préstamo.'
        ])
        ;
        $permiso67 = Permiso::firstOrCreate([
            'nombre' => 'Editar Préstamo','directriz' => 'prestamos.editar','descripcion' => 'Editar Datos de Préstamo Seleccionado.'
        ])
        ;
        $permiso68 = Permiso::firstOrCreate([
            'nombre' => 'Eliminar Préstamo','directriz' => 'prestamos.eliminar','descripcion' => 'Eliminar Registro de Préstamo Seleccionado.'
        ])
        ;
        $permiso69 = Permiso::firstOrCreate([
            'nombre' => 'Restaurar Préstamo','directriz' => 'prestamos.restaurar','descripcion' => 'Restaurar Registro de Préstamo Seleccionado.'
        ])
        ;

        $permiso70 = Permiso::firstOrCreate([
            'nombre' => 'Vista Cliente','directriz' => 'clientes.inicio','descripcion' => 'Vista Inicio Cliente.'
        ])
        ;
        $permiso71 = Permiso::firstOrCreate([
            'nombre' => 'Crear Cliente','directriz' => 'clientes.crear','descripcion' => 'Añadir Nuevo Cliente.'
        ])
        ;
        $permiso72 = Permiso::firstOrCreate([
            'nombre' => 'Editar Cliente','directriz' => 'clientes.editar','descripcion' => 'Editar Datos de Cliente Seleccionado.'
        ])
        ;
        $permiso73 = Permiso::firstOrCreate([
            'nombre' => 'Eliminar Cliente','directriz' => 'clientes.eliminar','descripcion' => 'Eliminar Registro de Cliente Seleccionado.'
        ])
        ;
        $permiso74 = Permiso::firstOrCreate([
            'nombre' => 'Restaurar Cliente','directriz' => 'clientes.restaurar','descripcion' => 'Restaurar Registro de Cliente Seleccionado.'
        ])
        ;
        $permiso75 = Permiso::firstOrCreate([
            'nombre' => 'Mostrar Cliente','directriz' => 'clientes.mostrar','descripcion' => 'Restaurar Registro de Cliente Seleccionado.'
        ])
        ;
        $permiso76 = Permiso::firstOrCreate([
            'nombre' => 'Reporte Cliente','directriz' => 'clientes.reporte','descripcion' => 'Restaurar Registro de Cliente Seleccionado.'
        ])
        ;

        $role1->permisos()->sync([
            $permiso1->id, $permiso2->id,$permiso3->id,$permiso4->id,$permiso5->id,$permiso6->id,$permiso7->id,$permiso8->id,$permiso9->id,$permiso10->id,
            $permiso11->id, $permiso12->id,$permiso13->id,$permiso14->id,$permiso15->id,$permiso16->id,$permiso17->id,$permiso18->id,$permiso19->id,$permiso20->id,
            $permiso21->id, $permiso22->id,$permiso23->id,$permiso24->id,$permiso25->id,$permiso26->id,$permiso27->id,$permiso28->id,$permiso29->id,$permiso30->id,
            $permiso31->id, $permiso32->id,$permiso33->id,$permiso34->id,$permiso35->id,$permiso36->id,$permiso37->id,$permiso38->id,$permiso39->id,$permiso40->id,
            $permiso41->id, $permiso42->id,$permiso43->id,$permiso44->id,$permiso45->id,$permiso46->id,$permiso47->id,$permiso48->id,$permiso49->id,$permiso50->id,
            $permiso51->id, $permiso52->id,$permiso53->id,$permiso54->id,$permiso55->id,$permiso56->id,$permiso57->id,$permiso58->id,$permiso59->id,$permiso60->id,
            $permiso61->id, $permiso62->id,$permiso63->id,$permiso64->id,$permiso65->id,$permiso66->id,$permiso67->id,$permiso68->id,$permiso69->id,$permiso70->id,
            $permiso71->id, $permiso72->id,$permiso73->id,$permiso74->id,$permiso75->id,$permiso76->id
        ]);
    }
}
