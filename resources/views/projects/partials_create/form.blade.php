<div class="row">

    <div class="form-group col-md-6 col-sm-12">
        <label for="project_name">Project Naam</label>
        <input type="text" class="form-control" id="project_name" name="name" placeholder="Manhattan Project">
        @if ($errors->has('name'))
            <span class="help-block text-danger">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
        @endif
    </div>

    <div class="form-group col-md-3 col-sm-12">
        <label for="project_number">Projectnummer</label>
        <input type="text" class="form-control" id="project_number" name="projectnumber" placeholder="12345678">
        @if ($errors->has('projectnumber'))
            <span class="help-block text-danger">
                <strong>{{ $errors->first('projectnumber') }}</strong>
            </span>
        @endif
    </div>

    <div class="form-group col-md-3 col-sm-12">
        <label for="project_contact">Contactpersoon</label>
        <select class="form-control" id="project_contact" name="project_contact_id">
            <option selected>Geen</option>
            @foreach($users as $user)
                <option value="{{$user->id}}">{{$user->name}}</option>
            @endforeach
        </select>
    </div>

</div>

<div class="row">

    <div class="form-group col-md-12">
        <label for="project_description">Project Omschrijving</label>
        <textarea class="form-control" id="project_description" name="description" rows="4"></textarea>
        @if ($errors->has('description'))
            <span class="help-block text-danger">
                <strong>{{ $errors->first('description') }}</strong>
            </span>
        @endif
    </div>
</div>
