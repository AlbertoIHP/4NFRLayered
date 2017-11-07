<?php

use Illuminate\Database\Seeder;

class adminmodule extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
        	'name' => 'Adecuación Funcional'
        ]);

        DB::table('categories')->insert([
            'name' => 'Eficiencia de Desempeño'
        ]);

        DB::table('categories')->insert([
            'name' => 'Compatibilidad'
        ]);

        DB::table('categories')->insert([
            'name' => 'Usabilidad'
        ]);

        DB::table('categories')->insert([
            'name' => 'Fiabilidad'
        ]);

        DB::table('categories')->insert([
            'name' => 'Seguridad'
        ]);

        DB::table('categories')->insert([
            'name' => 'Mantenibilidad'
        ]);

        DB::table('categories')->insert([
            'name' => 'Portabilidad'
        ]);

        DB::table('nfrs')->insert([
            'name' => 'Completitud funcional',
            'description' => 'Grado en el cual el conjunto de funcionalidades cubre todas las tareas y los objetivos del usuario especificados.',
            'categories_id' => 1
        ]);

        DB::table('nfrs')->insert([
            'name' => 'Corrección funcional',
            'description' => 'Capacidad del producto o sistema para proveer resultados correctos con el nivel de precisión requerido.',
            'categories_id' => 1
        ]);

        DB::table('nfrs')->insert([
            'name' => 'Pertinencia funcional',
            'description' => 'Capacidad del producto software para proporcionar un conjunto apropiado de funciones para tareas y objetivos de usuario especificados.',
            'categories_id' => 1
        ]);

        DB::table('nfrs')->insert([
            'name' => 'Comportamiento temporal',
            'description' => ' Los tiempos de respuesta y procesamiento y los ratios de throughput de un sistema cuando lleva a cabo sus funciones bajo condiciones determinadas en relación con un banco de pruebas (benchmark) establecido.',
            'categories_id' => 2
        ]);

        DB::table('nfrs')->insert([
            'name' => 'Utilización de recursos',
            'description' => 'Las cantidades y tipos de recursos utilizados cuando el software lleva a cabo su función bajo condiciones determinadas.',
            'categories_id' => 2
        ]);

        DB::table('nfrs')->insert([
            'name' => 'Capacidad',
            'description' => 'Grado en que los límites máximos de un parámetro de un producto o sistema software cumplen con los requisitos.',
            'categories_id' => 2
        ]);

        DB::table('nfrs')->insert([
            'name' => 'Coexistencia',
            'description' => 'Capacidad del producto para coexistir con otro software independiente, en un entorno común, compartiendo recursos comunes sin detrimento.',
            'categories_id' => 3
        ]);

        DB::table('nfrs')->insert([
            'name' => 'Interoperabilidad',
            'description' => 'Capacidad de dos o más sistemas o componentes para intercambiar información y utilizar la información intercambiada.',
            'categories_id' => 3
        ]);

        DB::table('nfrs')->insert([
            'name' => 'Capacidad para reconocer su adecuación',
            'description' => 'apacidad del producto que permite al usuario entender si el software es adecuado para sus necesidades.',
            'categories_id' => 4
        ]);

        DB::table('nfrs')->insert([
            'name' => 'Capacidad de aprendizaje',
            'description' => 'Capacidad del producto que permite al usuario aprender su aplicación.',
            'categories_id' => 4
        ]);

        DB::table('nfrs')->insert([
            'name' => 'Capacidad para ser usado',
            'description' => 'Capacidad del producto que permite al usuario operarlo y controlarlo con facilidad.',
            'categories_id' => 4
        ]);

        DB::table('nfrs')->insert([
            'name' => 'Protección contra errores de usuario',
            'description' => 'Capacidad del sistema para proteger a los usuarios de hacer errores.',
            'categories_id' => 4
        ]);

        DB::table('nfrs')->insert([
            'name' => 'Estética de la interfaz de usuario',
            'description' => 'Capacidad de la interfaz de usuario  de agradar y satisfacer la interacción con el usuario.',
            'categories_id' => 4
        ]);

        DB::table('nfrs')->insert([
            'name' => 'Accesibilidad',
            'description' => ' Capacidad del producto que permite que sea utilizado por usuarios con determinadas características y discapacidades.',
            'categories_id' => 4
        ]);

        DB::table('nfrs')->insert([
            'name' => 'Madurez',
            'description' => 'Capacidad del sistema para satisfacer las necesidades de fiabilidad en condiciones normales.',
            'categories_id' => 5
        ]);

        DB::table('nfrs')->insert([
            'name' => 'Disponibilidad',
            'description' => 'Capacidad del sistema o componente de estar operativo y accesible para su uso cuando se requiere.',
            'categories_id' => 5
        ]);

        DB::table('nfrs')->insert([
            'name' => 'Tolerancia a fallos',
            'description' => 'Capacidad del sistema o componente para operar según lo previsto en presencia de fallos hardware o software.',
            'categories_id' => 5
        ]);

        DB::table('nfrs')->insert([
            'name' => 'Capacidad de recuperación',
            'description' => 'Capacidad del producto software para recuperar los datos directamente afectados y reestablecer el estado deseado del sistema en caso de interrupción o fallo.',
            'categories_id' => 5
        ]);

        DB::table('nfrs')->insert([
            'name' => 'Confidencialidad',
            'description' => 'Capacidad de protección contra el acceso de datos e información no autorizados, ya sea accidental o deliberadamente.',
            'categories_id' => 6
        ]);

        DB::table('nfrs')->insert([
            'name' => 'Integridad',
            'description' => 'Capacidad del sistema o componente para prevenir accesos o modificaciones no autorizados a datos o programas de ordenador.',
            'categories_id' => 6
        ]);


        DB::table('nfrs')->insert([
            'name' => 'No repudio',
            'description' => ' Capacidad de demostrar las acciones o eventos que han tenido lugar, de manera que dichas acciones o eventos no puedan ser repudiados posteriormente.',
            'categories_id' => 6
        ]);


        DB::table('nfrs')->insert([
            'name' => 'Responsabilidad',
            'description' => 'Capacidad de rastrear de forma inequívoca las acciones de una entidad.',
            'categories_id' => 6
        ]);


        DB::table('nfrs')->insert([
            'name' => 'Autenticidad',
            'description' => 'Capacidad de demostrar la identidad de un sujeto o un recurso.',
            'categories_id' => 6
        ]);

        DB::table('nfrs')->insert([
            'name' => 'Modularidad',
            'description' => 'Capacidad de un sistema o programa de ordenador (compuesto de componentes discretos) que permite que un cambio en un componente tenga un impacto mínimo en los demás.',
            'categories_id' => 7
        ]);

        DB::table('nfrs')->insert([
            'name' => 'Reusabilidad',
            'description' => 'Capacidad de un activo que permite que sea utilizado en más de un sistema software o en la construcción de otros activos.',
            'categories_id' => 7
        ]);

        DB::table('nfrs')->insert([
            'name' => 'Analizabilidad',
            'description' => 'Facilidad con la que se puede evaluar el impacto de un determinado cambio sobre el resto del software, diagnosticar las deficiencias o causas de fallos en el software, o identificar las partes a modificar.',
            'categories_id' => 7
        ]);

        DB::table('nfrs')->insert([
            'name' => 'Capacidad para ser modificado',
            'description' => 'Capacidad del producto que permite que sea modificado de forma efectiva y eficiente sin introducir defectos o degradar el desempeño.',
            'categories_id' => 7
        ]);

        DB::table('nfrs')->insert([
            'name' => 'Capacidad para ser probado',
            'description' => 'Facilidad con la que se pueden establecer criterios de prueba para un sistema o componente y con la que se pueden llevar a cabo las pruebas para determinar si se cumplen dichos criterios.',
            'categories_id' => 7
        ]);

        DB::table('nfrs')->insert([
            'name' => 'Adaptabilidad',
            'description' => 'Capacidad del producto que le permite ser adaptado de forma efectiva y eficiente a diferentes entornos determinados de hardware, software, operacionales o de uso.',
            'categories_id' => 8
        ]);

        DB::table('nfrs')->insert([
            'name' => 'Capacidad para ser instalado',
            'description' => ' Facilidad con la que el producto se puede instalar y/o desinstalar de forma exitosa en un determinado entorno.',
            'categories_id' => 8
        ]);

        DB::table('nfrs')->insert([
            'name' => 'Capacidad para ser reemplazado',
            'description' => ' Capacidad del producto para ser utilizado en lugar de otro producto software determinado con el mismo propósito y en el mismo entorno.',
            'categories_id' => 8
        ]);

        DB::table('relevances')->insert([
            'name' => 'Irrelevante',
            'description' => 'No es relevante, pero de todas maneras debe de ser considerado.',
            'weigth' => 0
        ]);

        DB::table('relevances')->insert([
            'name' => 'Relevante',
            'description' => 'Es relevante, por lo que debe ser considerado como un requisito alcanzable si es que los plazos lo permiten.',
            'weigth' => 1
        ]);

        DB::table('relevances')->insert([
            'name' => 'Critico',
            'description' => 'Es critico, por lo que debe ser considerado cono alcanzable e incluido en las proyecciones de tiempo.',
            'weigth' => 2
        ]);

        DB::table('relevances')->insert([
            'name' => 'Muy critico',
            'description' => 'Es demasiado critico, por lo que debe ser considerado como requisito a satisfacer, ya que sin esto no da valor agregado.',
            'weigth' => 3
        ]);

        DB::table('professions')->insert([
            'name' => 'Ingeniero Civil Informatico',
            'description' => 'Ingeniero orientado al desarrollo de software bajo la ingenieria de software.'
        ]);

        DB::table('professions')->insert([
            'name' => 'Ingeniero Civil Telematico',
            'description' => 'Ingeniero Telematico'
        ]);

        DB::table('professions')->insert([
            'name' => 'Ingeniero Civil Ambiental',
            'description' => 'Ingeniero Ambiental'
        ]);

        DB::table('professions')->insert([
            'name' => 'Ingeniero Civil Quimico',
            'description' => 'Ingeniero Quimico'
        ]);

        DB::table('professions')->insert([
            'name' => 'Ingeniero Civil Biotecnologia',
            'description' => 'Ingeniero Biotecnologia'
        ]);

        DB::table('professions')->insert([
            'name' => 'Ingeniero Civil Mecanico',
            'description' => 'Ingeniero Mecanico'
        ]);

        DB::table('professions')->insert([
            'name' => 'Ingeniero Civil ',
            'description' => 'Ingeniero Civil'
        ]);

        DB::table('areas')->insert([
            'name' => 'Salud',
            'description' => 'El area de la salud, esta orientada a Hospitales, Clinicas, Consultorios, entre otros.'
        ]);

        DB::table('areas')->insert([
            'name' => 'Educacion',
            'description' => 'El area de la educacion, esta orientada a Colegios, Liceos, Universidades, entre otros.'
        ]);

        DB::table('areas')->insert([
            'name' => 'Publico',
            'description' => 'El area de la publico, esta orientada a Municipalidades, licitaciones municipales, entre otros.'
        ]);



        DB::table('functionalities')->insert([
            'name' => 'roles'
        ]);



        DB::table('functionalities')->insert([
            'name' => 'areas'
        ]);



        DB::table('functionalities')->insert([
            'name' => 'professions'
        ]);



        DB::table('functionalities')->insert([
            'name' => 'relevances'
        ]);



        DB::table('functionalities')->insert([
            'name' => 'nfrs'
        ]);



        DB::table('functionalities')->insert([
            'name' => 'categories'
        ]);



        DB::table('functionalities')->insert([
            'name' => 'users'
        ]);



        DB::table('functionalities')->insert([
            'name' => 'projects'
        ]);



        DB::table('functionalities')->insert([
            'name' => 'stakeholders'
        ]);



        DB::table('functionalities')->insert([
            'name' => 'goals'
        ]);



        DB::table('functionalities')->insert([
            'name' => 'softgoals'
        ]);



        DB::table('functionalities')->insert([
            'name' => 'categories'
        ]);



        DB::table('roles')->insert([
            'name' => 'Admin'
        ]);



        DB::table('permissions')->insert([
            'roles_id' => 1,
            'functionalities_id' => 1,
            'write' => '1',
            'erase' => '1',
            'update' => '1',
            'view' => '1'
        ]);



        DB::table('permissions')->insert([
            'roles_id' => 1,
            'functionalities_id' => 2,
            'write' => '1',
            'erase' => '1',
            'update' => '1',
            'view' => '1'
        ]);



        DB::table('permissions')->insert([
            'roles_id' => 1,
            'functionalities_id' => 3,
            'write' => '1',
            'erase' => '1',
            'update' => '1',
            'view' => '1'
        ]);



        DB::table('permissions')->insert([
            'roles_id' => 1,
            'functionalities_id' => 4,
            'write' => '1',
            'erase' => '1',
            'update' => '1',
            'view' => '1'
        ]);



        DB::table('permissions')->insert([
            'roles_id' => 1,
            'functionalities_id' => 5,
            'write' => '1',
            'erase' => '1',
            'update' => '1',
            'view' => '1'
        ]);



        DB::table('permissions')->insert([
            'roles_id' => 1,
            'functionalities_id' => 6,
            'write' => '1',
            'erase' => '1',
            'update' => '1',
            'view' => '1'
        ]);



        DB::table('permissions')->insert([
            'roles_id' => 1,
            'functionalities_id' => 7,
            'write' => '1',
            'erase' => '1',
            'update' => '1',
            'view' => '1'
        ]);



        DB::table('permissions')->insert([
            'roles_id' => 1,
            'functionalities_id' => 8,
            'write' => '1',
            'erase' => '1',
            'update' => '1',
            'view' => '1'
        ]);



        DB::table('permissions')->insert([
            'roles_id' => 1,
            'functionalities_id' => 9,
            'write' => '1',
            'erase' => '1',
            'update' => '1',
            'view' => '1'
        ]);



        DB::table('permissions')->insert([
            'roles_id' => 1,
            'functionalities_id' => 10,
            'write' => '1',
            'erase' => '1',
            'update' => '1',
            'view' => '1'
        ]);



        DB::table('permissions')->insert([
            'roles_id' => 1,
            'functionalities_id' => 11,
            'write' => '1',
            'erase' => '1',
            'update' => '1',
            'view' => '1'
        ]);



        DB::table('permissions')->insert([
            'roles_id' => 1,
            'functionalities_id' => 12,
            'write' => '1',
            'erase' => '1',
            'update' => '1',
            'view' => '1'
        ]);



    }
}
