<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateUserAPIRequest;
use App\Http\Requests\API\UpdateUserAPIRequest;

use App\Models\User;
use App\Models\Project;
use App\Models\Stakeholder;
use App\Models\Goal;
use App\Models\Softgoal;
use App\Models\SoftgoalNfr;

use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;


//CORREO TIII
use Illuminate\Support\Facades\Mail;
use Input;

use Illuminate\Support\Facades\DB;

/**
 * Class UserController
 * @package App\Http\Controllers\API
 */

class UserAPIController extends AppBaseController
{
    /** @var  UserRepository */
    private $userRepository;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepository = $userRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/users",
     *      summary="Get a listing of the Users.",
     *      tags={"User"},
     *      description="Get all Users",
     *      produces={"application/json"},
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="array",
     *                  @SWG\Items(ref="#/definitions/User")
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function index(Request $request)
    {
        $this->userRepository->pushCriteria(new RequestCriteria($request));
        $this->userRepository->pushCriteria(new LimitOffsetCriteria($request));
        $users = $this->userRepository->all();

        return $this->sendResponse($users->toArray(), 'Users retrieved successfully');
    }

    /**
     * @param CreateUserAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/users",
     *      summary="Store a newly created User in storage",
     *      tags={"User"},
     *      description="Store User",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="User that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/User")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/User"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
public function store(Request $request){

    $confirmation_code = str_random(30);
    $input = $request->all();

    $rules = [
      'email' => 'required',
      'password' => 'required',
    ];


    $data = [
      'email' => $request->email,
      'password' => bcrypt($request->password),
      'name' => $request->name,
      'roles_id' => $request->roles_id,
      'professions_id' => $request->professions_id,
      'confirmation_code' => $confirmation_code
    ];

    
    try {

      $validator = \Validator::make($data, $rules);

      if ($validator->fails()) {
        return [
          'created' => false,
          'errors' => $validator->errors()->all(),
        ];
      }else{

        Mail::send('email.validarCuenta', 
          ['confirmation_code' => $confirmation_code, 'email'=> $request->email, 'password' => $request->password], function ($message) {

            $message->to(Input::get('email'), Input::get('nombre'))
                ->subject('Por favor verifique su cuenta');

        });


        User::create($data);
        return ['created' => true];



      }
    } catch (\Exception $e) {
      \Log::info('Error creating user: ' . $e);
      return \Response::json(['created' => false], 500);
    }
  }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/users/{id}",
     *      summary="Display the specified User",
     *      tags={"User"},
     *      description="Get User",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of User",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/User"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function show($id)
    {
        /** @var User $user */
        $user = $this->userRepository->findWithoutFail($id);

        if (empty($user)) {
            return $this->sendError('User not found');
        }

        return $this->sendResponse($user->toArray(), 'User retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateUserAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/users/{id}",
     *      summary="Update the specified User in storage",
     *      tags={"User"},
     *      description="Update User",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of User",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="User that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/User")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/User"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateUserAPIRequest $request)
    {
        $input = $request->all();
        $input['password'] = bcrypt($request->password);

        /** @var User $user */
        $user = $this->userRepository->findWithoutFail($id);

        if (empty($user)) {
            return $this->sendError('User not found');
        }

        $user = $this->userRepository->update($input, $id);

        return $this->sendResponse($user->toArray(), 'User updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/users/{id}",
     *      summary="Remove the specified User from storage",
     *      tags={"User"},
     *      description="Delete User",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of User",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="string"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function destroy($id)
    {
        /** @var User $user */
        $user = $this->userRepository->findWithoutFail($id);

        if (empty($user)) {
            return $this->sendError('User not found');
        }

        $user->delete();

        return $this->sendResponse($id, 'User deleted successfully');
    }
    

      public function confirm ($confirmation_code) 
      {

        error_log(json_encode($confirmation_code));

        if (!$confirmation_code) 
        {
         return view('email.error');
        }


        
        $user = User::whereConfirmationCode($confirmation_code)->first();


        if (!$user) 
        {
            return view('email.error');;
        }



        $user->confirmed = 1;
        $user->confirmation_code = null;
        $user->save();


        // Creación de ejemplo
        // Agregar proyecto
        $newProject = [
            'name' => 'Sistema de administración de biblioteca',
            'description' => 'Este sistema permitirá la administración de la biblioteca, tanto de usaurios como de otros aspectos.',
            'time' => '00:00 PM',
            'date' => '05/20/2017',
            'users_id' => $user->id,
            'areas_id' => 3,
            'deadline' => 'Nov/12/2020'
        ];

        Project::create($newProject);

        // Obtener id del proyecto creado
        $idProject = DB::table('projects')->where('users_id', $user->id)->value('id');

        // Agregar stakeholders
        $newStake = [
            'name' => 'Socio',
            'description' => 'Persona ligada a la biblioteca, puede buscar libros, retornar libros, entre otros.',
            'function' => 'Es quien usará el sistema, para navegar por la biblioteca y realizar las acciones que estime pertinentes.',
            'professions_id' => 1,
            'projects_id' => $idProject,
            'time' => '00:00 PM',
            'date' => '05/20/2017'           
        ];

        Stakeholder::create($newStake);

        $newStake = [
            'name' => 'Bibliotecario',
            'description' => 'Es quien administra el sistema, puede agregar socios, libros, recibir libros, entre otros.',
            'function' => 'Administrador del sistema',
            'professions_id' => 5,
            'projects_id' => $idProject,
            'time' => '00:00 PM',
            'date' => '05/20/2017'          
        ];

        Stakeholder::create($newStake);

        // Obtener id de los stakeholders creados
        $stakes = DB::table('stakeholders')->where('projects_id', $idProject)->pluck('id');

        // Agregar goals a los stakeholders

        // SOCIO
        // Goals socio - Login
        $newGoal = [
            'name' => 'Login',
            'description' => 'Es la acción de entrar a el sistema mediante usuario y contraseña',
            'stakeholders_id' => $stakes[0],
            'relevances_id' => 4,
            'time' => '00:00 PM',
            'date' => '05/20/2017'
        ];

        Goal::create($newGoal);
              
        // Goals socio - Buscar libro      
        $newGoal = [
            'name' => 'Buscar libro',
            'description' => 'Buscar el libro al que quiere acceder el usuario mediante el uso del sistema',
            'stakeholders_id' => $stakes[0],
            'relevances_id' => 3,
            'time' => '00:00 PM',
            'date' => '05/20/2017'
        ];

        Goal::create($newGoal);

        // Goals socio - Pedir libro
        $newGoal = [
            'name' => 'Pedir libro',
            'description' => 'La capacidad que tiene el socio para pedir un libro prestado a la biblioteca',
            'stakeholders_id' => $stakes[0],
            'relevances_id' => 3,
            'time' => '00:00 PM',
            'date' => '05/20/2017'
        ];

        Goal::create($newGoal);

        // Goals socio - Devolver libro
        $newGoal = [
            'name' => 'Devolver libro',
            'description' => 'La acción que realiza el usuario luego de haber ocupado el libro, para registrar en el sistema que la devolución se ha realizado con exito',
            'stakeholders_id' => $stakes[0],
            'relevances_id' => 3,
            'time' => '00:00 PM',
            'date' => '05/20/2017'
        ];

        Goal::create($newGoal);

        // BIBLIOTECARIO
        // Goals bibliotecario - Agregar socio       
        $newGoal = [
            'name' => 'Agregar socio',
            'description' => 'Facultad del bibliotecario para agregar nuevos usuarios al sistema',
            'stakeholders_id' => $stakes[1],
            'relevances_id' => 4,
            'time' => '00:00 PM',
            'date' => '05/20/2017'
        ];

        Goal::create($newGoal);

        // Goals bibliotecario - Agregar item
        $newGoal = [
            'name' => 'Agregar item',
            'description' => 'Facultad del bibliotecario para agregar nuevos productos y registrarlos en el sistema',
            'stakeholders_id' => $stakes[1],
            'relevances_id' => 2,
            'time' => '00:00 PM',
            'date' => '05/20/2017'
        ];

        Goal::create($newGoal);

        // Goals bibliotecario - Libro de publicaciones
        $newGoal = [
            'name' => 'Libro de publicaciones',
            'description' => 'Permite al bibliotecario llevar un registro sobre los productos y usuarios de su sistema',
            'stakeholders_id' => $stakes[1],
            'relevances_id' => 3,
            'time' => '00:00 PM',
            'date' => '05/20/2017'
        ];

        Goal::create($newGoal);

        // Goals bibliotecario - Recibir libro
        $newGoal = [
            'name' => 'Recibir libro',
            'description' => 'Facultad del bibliotecario para recibir un libro prestado, y registrarlo en el sistema',
            'stakeholders_id' => $stakes[1],
            'relevances_id' => 3,
            'time' => '00:00 PM',
            'date' => '05/20/2017'
        ];

        Goal::create($newGoal);


        // Obtener id de los goals creados
        $goalsSocio = DB::table('goals')->where('stakeholders_id', $stakes[0])->pluck('id');

        $goalsBiblio = DB::table('goals')->where('stakeholders_id', $stakes[1])->pluck('id');
        

        // Agregar subgoals a los goals
        
        // SOCIO
        // Subgoals login estudiante
        $newSub = [
            'name' => 'Login estudiante',
            'description' => 'Ingreso de un usuario de tipo estudiante al sistema',
            'goals_id' => $goalsSocio[0],
            'relevances_id' => 4,
            'time' => '00:00 PM',
            'date' => '05/20/2017'
        ];

        Softgoal::create($newSub);

        // Subgoals Login empleado
        $newSub = [
            'name' => 'Login empleado',
            'description' => 'Ingreso de un usuario de tipo empleado al sistema',
            'goals_id' => $goalsSocio[0],
            'relevances_id' => 4,
            'time' => '00:00 PM',
            'date' => '05/20/2017'
        ];

        Softgoal::create($newSub);

        // Subgoals Login editor
        $newSub = [
            'name' => 'Login editor',
            'description' => 'Ingreso de un usuario de tipo editor al sistema',
            'goals_id' => $goalsSocio[0],
            'relevances_id' => 4,
            'time' => '00:00 PM',
            'date' => '05/20/2017'
        ];

        Softgoal::create($newSub);
        
        // Subgoals Buscar por titulo
        $newSub = [
            'name' => 'Buscar por título',
            'description' => 'La capacidad que tiene el usuario de filtrar su búsqueda por título',
            'goals_id' => $goalsSocio[1],
            'relevances_id' => 2,
            'time' => '00:00 PM',
            'date' => '05/20/2017'
        ];

        Softgoal::create($newSub);
        
        // Subgoals Buscar por autor
        $newSub = [
            'name' => 'Buscar por autor',
            'description' => 'La capacidad que tiene el usuario de filtrar su búsqueda por autor',
            'goals_id' => $goalsSocio[1],
            'relevances_id' => 2,
            'time' => '00:00 PM',
            'date' => '05/20/2017'
        ];

        Softgoal::create($newSub);
        
        // Subgoals Buscar por ISBN
        $newSub = [
            'name' => 'Buscar por ISBN',
            'description' => 'La capacidad que tiene el usuario de filtrar su búsqueda por ISBN',
            'goals_id' => $goalsSocio[1],
            'relevances_id' => 2,
            'time' => '00:00 PM',
            'date' => '05/20/2017'
        ];

        Softgoal::create($newSub);
        
        // Subgoals Seleccionar libro
        $newSub = [
            'name' => 'Seleccionar libro"',
            'description' => 'La capacidad del usuario de seleccionar el o los libros que desea',
            'goals_id' => $goalsSocio[2],
            'relevances_id' => 4,
            'time' => '00:00 PM',
            'date' => '05/20/2017'
        ];

        Softgoal::create($newSub);
       
        // Subgoals Obtener libro
        $newSub = [
            'name' => 'Obtener libro',
            'description' => 'La capacidad que tiene el usuario de obtener el libro que ha seleccionado',
            'goals_id' => $goalsSocio[2],
            'relevances_id' => 4,
            'time' => '00:00 PM',
            'date' => '05/20/2017'
        ];

        Softgoal::create($newSub);
        
        // Subgoals Proporcionar detalles
        $newSub = [
            'name' => 'Proporcionar detalles',
            'description' => 'La facultad que tiene el usuario de dejar detalles sobre el libro',
            'goals_id' => $goalsSocio[3],
            'relevances_id' => 2,
            'time' => '00:00 PM',
            'date' => '05/20/2017'
        ];

        Softgoal::create($newSub);
        
        // Subgoals Devolver libro
        $newSub = [
            'name' => 'Devolver libro',
            'description' => 'La facultad que tiene el usuario de devolver el libro que tomó prestado',
            'goals_id' => $goalsSocio[3],
            'relevances_id' => 2,
            'time' => '00:00 PM',
            'date' => '05/20/2017'
        ];

        Softgoal::create($newSub);
        
        // BIBLIOTECARIO
        // Subgoals agregar estudiante
        $newSub = [
            'name' => 'Agregar estudiante',
            'description' => 'Ingresar un nuevo usuario del tipo estudiante',
            'goals_id' => $goalsBiblio[0],
            'relevances_id' => 4,
            'time' => '00:00 PM',
            'date' => '05/20/2017'
        ];

        Softgoal::create($newSub);
        
        // Subgoals Agregar empleado
        $newSub = [
            'name' => 'Agregar empleado',
            'description' => 'Ingresar un nuevo usuario del tipo empleado',
            'goals_id' => $goalsBiblio[0],
            'relevances_id' => 4,
            'time' => '00:00 PM',
            'date' => '05/20/2017'
        ];

        Softgoal::create($newSub);
        
        // Subgoals Agregar editor
        $newSub = [
            'name' => 'Agregar editor',
            'description' => 'Ingresar un nuevo usuario del tipo editor',
            'goals_id' => $goalsBiblio[0],
            'relevances_id' => 4,
            'time' => '00:00 PM',
            'date' => '05/20/2017'
        ];

        Softgoal::create($newSub);
        
        // Subgoals Agregar libros
        $newSub = [
            'name' => 'Agregar libros',
            'description' => 'Ingresar nuevos libros al inventario de la biblioteca',
            'goals_id' => $goalsBiblio[1],
            'relevances_id' => 3,
            'time' => '00:00 PM',
            'date' => '05/20/2017'
        ];

        Softgoal::create($newSub);
        
        // Subgoals Agregar revistas
        $newSub = [
            'name' => 'Agregar revistas',
            'description' => 'Ingresar nuevas revistas o periódicos en el inventario de la biblioteca',
            'goals_id' => $goalsBiblio[1],
            'relevances_id' => 3,
            'time' => '00:00 PM',
            'date' => '05/20/2017'
        ];

        Softgoal::create($newSub);
        
        // Subgoals Agregar CD's
        $newSub = [
            'name' => 'Agregar CDs',
            'description' => 'Ingresar nuevos CDs al inventario de la biblioteca',
            'goals_id' => $goalsBiblio[1],
            'relevances_id' => 3,
            'time' => '00:00 PM',
            'date' => '05/20/2017'
        ];

        Softgoal::create($newSub);
        
        // Subgoals Verificar limite
        $newSub = [
            'name' => 'Verificar límite',
            'description' => 'Ver el límite de tiempo con que se prestó el libro',
            'goals_id' => $goalsBiblio[2],
            'relevances_id' => 2,
            'time' => '00:00 PM',
            'date' => '05/20/2017'
        ];

        Softgoal::create($newSub);
        
        // Subgoals Libro de publicaciones
        $newSub = [
            'name' => 'Libro de publicaciones',
            'description' => 'Libro donde se verifica la información relevante de los items',
            'goals_id' => $goalsBiblio[2],
            'relevances_id' => 2,
            'time' => '00:00 PM',
            'date' => '05/20/2017'
        ];

        Softgoal::create($newSub);
        
        // Subgoals Actualizar cuenta
        $newSub = [
            'name' => 'Actualizar cuenta',
            'description' => 'Facultad del bibliotecario para actualizar las cuentas de los usuarios',
            'goals_id' => $goalsBiblio[2],
            'relevances_id' => 3,
            'time' => '00:00 PM',
            'date' => '05/20/2017'
        ];

        Softgoal::create($newSub);
        
        // Subgoals obtener detalles
        $newSub = [
            'name' => 'Obtener detalles',
            'description' => 'Ingresar detalles con respecto a la devolución del libro, por ejemplo, estado de libro, días de retraso, entre otros',
            'goals_id' => $goalsBiblio[3],
            'relevances_id' => 2,
            'time' => '00:00 PM',
            'date' => '05/20/2017'
        ];

        Softgoal::create($newSub);
        
        // Subgoals Actualizar cuenta 2
        $newSub = [
            'name' => 'Actualizar cuenta',
            'description' => 'Actualizar cuenta luego de haber o no recibido un libro, para cambiar por ejemplo, el estado de un usuario de Devuelve libros a Persona que no los devuelve',
            'goals_id' => $goalsBiblio[3],
            'relevances_id' => 4,
            'time' => '00:00 PM',
            'date' => '05/20/2017'
        ];

        Softgoal::create($newSub);
        
        //Obtener id de los subgoals creados
        $subSocio1 = DB::table('softgoals')->where('goals_id', $goalsSocio[0])->pluck('id');

        $subSocio2 = DB::table('softgoals')->where('goals_id', $goalsSocio[1])->pluck('id');

        $subSocio3 = DB::table('softgoals')->where('goals_id', $goalsSocio[2])->pluck('id');

        $subSocio4 = DB::table('softgoals')->where('goals_id', $goalsSocio[3])->pluck('id');

        $subBiblio1 = DB::table('softgoals')->where('goals_id', $goalsBiblio[0])->pluck('id');

        $subBiblio2 = DB::table('softgoals')->where('goals_id', $goalsBiblio[1])->pluck('id');

        $subBiblio3 = DB::table('softgoals')->where('goals_id', $goalsBiblio[2])->pluck('id');

        $subBiblio4 = DB::table('softgoals')->where('goals_id', $goalsBiblio[3])->pluck('id');


        // Agregar NFR
        // SOCIO
        // NFR login estudiante
        $newNfr = [
            'nfrs_id' => 23,
            'softgoals_id' => $subSocio1[0],
            'time' => '00:00 PM',
            'date' => '05/20/2017'
        ];

        SoftgoalNfr::create($newNfr);

        // NFR login empleado
        $newNfr = [
            'nfrs_id' => 23,
            'softgoals_id' => $subSocio1[1],
            'time' => '00:00 PM',
            'date' => '05/20/2017'
        ];

        SoftgoalNfr::create($newNfr);

        // NFR login editor
        $newNfr = [
            'nfrs_id' => 23,
            'softgoals_id' => $subSocio1[2],
            'time' => '00:00 PM',
            'date' => '05/20/2017'
        ];

        SoftgoalNfr::create($newNfr);
        
        // NFR buscar por titulo
        $newNfr = [
            'nfrs_id' => 11,
            'softgoals_id' => $subSocio2[0],
            'time' => '00:00 PM',
            'date' => '05/20/2017'
        ];

        SoftgoalNfr::create($newNfr);
        
        // NFR buscar por titulo
        $newNfr = [
            'nfrs_id' => 6,
            'softgoals_id' => $subSocio2[0],
            'time' => '00:00 PM',
            'date' => '05/20/2017'
        ];

        SoftgoalNfr::create($newNfr);

        // NFR buscar por autor        
        $newNfr = [
            'nfrs_id' => 11,
            'softgoals_id' => $subSocio2[1],
            'time' => '00:00 PM',
            'date' => '05/20/2017'
        ];

        SoftgoalNfr::create($newNfr);
        
        // NFR buscar por autor
        $newNfr = [
            'nfrs_id' => 6,
            'softgoals_id' => $subSocio2[1],
            'time' => '00:00 PM',
            'date' => '05/20/2017'
        ];

        SoftgoalNfr::create($newNfr);
        
        // NFR buscar por ISBN
        $newNfr = [
            'nfrs_id' => 11,
            'softgoals_id' => $subSocio2[2],
            'time' => '00:00 PM',
            'date' => '05/20/2017'
        ];

        SoftgoalNfr::create($newNfr);
        
        // NFR buscar por ISBN
        $newNfr = [
            'nfrs_id' => 6,
            'softgoals_id' => $subSocio2[2],
            'time' => '00:00 PM',
            'date' => '05/20/2017'
        ];

        SoftgoalNfr::create($newNfr);
        
        // NFR selecionar libro
        $newNfr = [
            'nfrs_id' => 11,
            'softgoals_id' => $subSocio3[0],
            'time' => '00:00 PM',
            'date' => '05/20/2017'
        ];

        SoftgoalNfr::create($newNfr);
        
        // NFR obtener libro
        $newNfr = [
            'nfrs_id' => 11,
            'softgoals_id' => $subSocio3[1],
            'time' => '00:00 PM',
            'date' => '05/20/2017'
        ];

        SoftgoalNfr::create($newNfr);
        
        // NFR obtener libro
        $newNfr = [
            'nfrs_id' => 6,
            'softgoals_id' => $subSocio3[1],
            'time' => '00:00 PM',
            'date' => '05/20/2017'
        ];

        SoftgoalNfr::create($newNfr);
        
        // NFR proveer detalles
        $newNfr = [
            'nfrs_id' => 11,
            'softgoals_id' => $subSocio4[0],
            'time' => '00:00 PM',
            'date' => '05/20/2017'
        ];

        SoftgoalNfr::create($newNfr);
        
        // NFR retornar libro
        $newNfr = [
            'nfrs_id' => 11,
            'softgoals_id' => $subSocio4[1],
            'time' => '00:00 PM',
            'date' => '05/20/2017'
        ];

        SoftgoalNfr::create($newNfr);
        

        // BIBLIOTECARIO
        // NFR agregar estudiante
        $newNfr = [
            'nfrs_id' => 3,
            'softgoals_id' => $subBiblio1[0],
            'time' => '00:00 PM',
            'date' => '05/20/2017'
        ];

        SoftgoalNfr::create($newNfr);
        
        // NFR agregar empleado
        $newNfr = [
            'nfrs_id' => 3,
            'softgoals_id' => $subBiblio1[1],
            'time' => '00:00 PM',
            'date' => '05/20/2017'
        ];

        SoftgoalNfr::create($newNfr);
        
        // NFR agregar editor
        $newNfr = [
            'nfrs_id' => 3,
            'softgoals_id' => $subBiblio1[2],
            'time' => '00:00 PM',
            'date' => '05/20/2017'
        ];

        SoftgoalNfr::create($newNfr);
        
        // NFR agregar libros
        $newNfr = [
            'nfrs_id' => 11,
            'softgoals_id' => $subBiblio2[0],
            'time' => '00:00 PM',
            'date' => '05/20/2017'
        ];

        SoftgoalNfr::create($newNfr);
        
        // NFR agregar revistas
        $newNfr = [
            'nfrs_id' => 11,
            'softgoals_id' => $subBiblio2[1],
            'time' => '00:00 PM',
            'date' => '05/20/2017'
        ];

        SoftgoalNfr::create($newNfr);
        
        // NFR agregar CD's
        $newNfr = [
            'nfrs_id' => 11,
            'softgoals_id' => $subBiblio2[2],
            'time' => '00:00 PM',
            'date' => '05/20/2017'
        ];

        SoftgoalNfr::create($newNfr);
        
        // NFR Verificar límite
        $newNfr = [
            'nfrs_id' => 16,
            'softgoals_id' => $subBiblio3[0],
            'time' => '00:00 PM',
            'date' => '05/20/2017'
        ];

        SoftgoalNfr::create($newNfr);
        
        // NFR libro de publicaciones
        $newNfr = [
            'nfrs_id' => 11,
            'softgoals_id' => $subBiblio3[1],
            'time' => '00:00 PM',
            'date' => '05/20/2017'
        ];

        SoftgoalNfr::create($newNfr);

        // NFR libro de publicaciones
        $newNfr = [
            'nfrs_id' => 6,
            'softgoals_id' => $subBiblio3[1],
            'time' => '00:00 PM',
            'date' => '05/20/2017'
        ];

        SoftgoalNfr::create($newNfr);

        // NFR Actualizar cuenta
        $newNfr = [
            'nfrs_id' => 19,
            'softgoals_id' => $subBiblio3[2],
            'time' => '00:00 PM',
            'date' => '05/20/2017'
        ];

        // NFR Actualizar cuenta
        SoftgoalNfr::create($newNfr);

        $newNfr = [
            'nfrs_id' => 16,
            'softgoals_id' => $subBiblio3[2],
            'time' => '00:00 PM',
            'date' => '05/20/2017'
        ];

        SoftgoalNfr::create($newNfr);

        //NFR Obtener detalles
        $newNfr = [
            'nfrs_id' => 11,
            'softgoals_id' => $subBiblio4[0],
            'time' => '00:00 PM',
            'date' => '05/20/2017'
        ];

        SoftgoalNfr::create($newNfr);

        // NFR Actualizar cuenta
        $newNfr = [
            'nfrs_id' => 16,
            'softgoals_id' => $subBiblio4[1],
            'time' => '00:00 PM',
            'date' => '05/20/2017'
        ];

        SoftgoalNfr::create($newNfr);

        // NFR Actualizar cuenta
        $newNfr = [
            'nfrs_id' => 19,
            'softgoals_id' => $subBiblio4[1],
            'time' => '00:00 PM',
            'date' => '05/20/2017'
        ];

        SoftgoalNfr::create($newNfr);

        return view('email.confirmacion');

      }

}
