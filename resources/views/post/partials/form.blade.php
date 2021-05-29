<div class="form-group">
    <label for="title">Title</label>
    <input class="form-control" id ="title" type="text" name="title" value="{{ old('title', optional($post ?? null)->title) }}">
</div>
        @error('title')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="form-group">
            <label for="content">Content</label>
            <textarea class="form-control" name="content" id="content" cols="30" rows="10">{{ old('content',optional($post ?? null)->content) }}</textarea>
        </div>
    <x-errors/>