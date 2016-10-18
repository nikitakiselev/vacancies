<select name="area_id" class="form-control search-area-selector input-lg" v-model="area_id">
    @foreach($areas as $area)
        <option value="{{ $area->id }}">
            {{ $area->name }}
        </option>
    @endforeach
</select>