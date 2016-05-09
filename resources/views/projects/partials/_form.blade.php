<input type="hidden" name="_token" value="{{ csrf_token() }}">

<div class="form-group"
     <labe>Name</labe>    
    <input name="name" class="input-sm" placeholder="name"/>
</div>
<div class="form-group">
    <label>Slug</label>
    <input name="slug" class="input-lg" placeholder="slug"/>
</div>
<div class="form-group">
    <button type="submit" class="btn btn-primary">{{ $submit_text }}</button>
</div>