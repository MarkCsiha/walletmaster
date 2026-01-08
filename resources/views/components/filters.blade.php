<div>
    <div class="row">
        <div class="col-md-3">
            <label for="category">Kategória</label>
            <select name="category" id="category" class="form-control">
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label for="From">Mettől</label>
            <input type="date" id="from" name="from" class="form-control">
        </div>
        <div class="col-md-3">
            <label for="To">Meddig</label>
            <input type="date" id="to" name="to" class="form-control">
        </div>
        <div class="col-md-3">
            <input type="button" class="btn btn-success" value="Filter" onclick="getData()">
        </div>
    </div>
</div>