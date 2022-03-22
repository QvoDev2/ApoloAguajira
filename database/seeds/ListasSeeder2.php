<?php

use Illuminate\Database\Seeder;

class ListasSeeder2 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('ALTER TABLE listas AUTO_INCREMENT=1');
        DB::statement("
            INSERT INTO `listas` (`codigo`, `nombre`, `descripcion`, `lista_id`, `tipo_lista_id`, `editable`) VALUES
            (null, 'GUARDIANES', null, null, 10, '1'),
            (null, 'EXPERTOS', null, null, 10, '1'),
            (null, 'COBASEC', null, null, 10, '1'),
            (null, 'STARCOOP', null, null, 10, '1'),
            (null, 'NÁPOLES', null, null, 10, '1'),
            (null, 'DELTHAC-1', null, null, 10, '1'),
            (null, 'INSEVIG', null, null, 10, '1'),
            (null, 'SURAMÉRICA', null, null, 10, '1'),
            (null, 'AMCOVIT', null, null, 10, '1'),
            
            (null, 'BANCAMIA S.A.', null, null, 11, 1),
            (null, 'BANCO AGRARIO', null, null, 11, 1),
            (null, 'BANCO AV VILLAS', null, null, 11, 1),
            (null, 'BANCO CAJA SOCIAL BCSC S.A.', null, null, 11, 1),
            (null, 'BANCO COOPERATIVO COOPCENTRAL', null, null, 11, 1),
            (null, 'BANCO CREDIFINANCIERA S.A.', null, null, 11, 1),
            (null, 'BANCO DAVIVIENDA S.A.', null, null, 11, 1),
            (null, 'BANCO DE BOGOTA', null, null, 11, 1),
            (null, 'BANCO DE OCCIDENTE', null, null, 11, 1),
            (null, 'BANCO FALABELLA S.A.', null, null, 11, 1),
            (null, 'BANCO FINANDINA S.A.', null, null, 11, 1),
            (null, 'BANCO GNB SUDAMERIS', null, null, 11, 1),
            (null, 'BANCO J.P. MORGAN COLOMBIA S.A', null, null, 11, 1),
            (null, 'BANCO MUNDO MUJER', null, null, 11, 1),
            (null, 'BANCO PICHINCHA', null, null, 11, 1),
            (null, 'BANCO POPULAR', null, null, 11, 1),
            (null, 'BANCO SANTANDER DE NEGOCIOS COLOMBIA S.A.', null, null, 11, 1),
            (null, 'BANCO SERFINANZA S.A', null, null, 11, 1),
            (null, 'BANCO W S.A.', null, null, 11, 1),
            (null, 'BANCOLDEX S.A.', null, null, 11, 1),
            (null, 'BANCOLOMBIA', null, null, 11, 1),
            (null, 'BANCOOMEVA', null, null, 11, 1),
            (null, 'BBVA COLOMBIA', null, null, 11, 1),
            (null, 'COLTEFINANCIERA S.A', null, null, 11, 1),
            (null, 'CONFIAR', null, null, 11, 1),
            (null, 'COOFINEP COOPERATIVA FINANCIERA', null, null, 11, 1),
            (null, 'COOPERATIVA FINANCIERA DE ANTIOQUIA', null, null, 11, 1),
            (null, 'COOTRAFA COOPERATIVA FINANCIERA', null, null, 11, 1),
            (null, 'FINANCIERA JURISCOOP S.A. COMPAÑÍA DE FINANCIAMIENTO', null, null, 11, 1),
            (null, 'GIROS Y FINANZAS CF', null, null, 11, 1),
            (null, 'SCOTIABANK COLPATRIA S.A', null, null, 11, 1),

            (null, 'AHORROS', null, null, 12, 1),
            (null, 'CORRIENTE', null, null, 12, 1)
        ");
    }
}
