{{csrf_field()}}
<div class="form-group">
    <label for="email">Email adres</label>
    <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{$user->email or old('email')}}">
</div>
<div class="form-group">
    <label for="name">Naam</label>
    <input type="text" class="form-control" name="name" id="name" placeholder="Naam" value="{{$user->name or old('name')}}">
</div>
<div class="form-group">
    <label for="exampleInputPassword1">Wachtwoord</label>
    <input type="password" class="form-control" name="password" id="exampleInputPassword1"
           placeholder="Wachtwoord">
</div>