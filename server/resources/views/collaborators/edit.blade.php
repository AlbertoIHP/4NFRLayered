@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Collaborator
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($collaborator, ['route' => ['collaborators.update', $collaborator->id], 'method' => 'patch']) !!}

                        @include('collaborators.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection