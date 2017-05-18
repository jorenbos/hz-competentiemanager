<div class="row">

    <div class="form-group col-md-6 col-sm-12">
        <label for="project_name">Project Naam</label>
        <input type="text" class="form-control" id="project_name" placeholder="Manhattan Project">
    </div>

    <div class="form-group col-md-3 col-sm-12">
        <label for="project_number">Projectnummer</label>
        <input type="text" class="form-control" id="project_number" placeholder="12345678">
    </div>

    <div class="form-group col-md-3 col-sm-12">
        <label for="project_contact">Contactpersoon</label>
        <select class="form-control" id="project_contact">
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
        <textarea class="form-control" id="project_description" rows="4"></textarea>
    </div>

</div>

