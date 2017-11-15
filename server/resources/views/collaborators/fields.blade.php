<!-- Users Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('users_id', 'Users Id:') !!}
    {!! Form::number('users_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Projects Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('projects_id', 'Projects Id:') !!}
    {!! Form::number('projects_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('collaborators.index') !!}" class="btn btn-default">Cancel</a>
</div>
