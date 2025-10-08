<html>
<head></head>
<body>
    <h1>Editar Motorcycle</h1>

    <form action="{{ route('motorcycles.update', $motorcycle) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label for="brand">Brand</label>
            <input type="text" id="brand" name="brand" value="{{ $motorcycle->brand }}" required>
        </div>

        <div>
            <label for="model">Model</label>
            <input type="text" id="model" name="model" value="{{ $motorcycle->model }}" required>
        </div>

        <div>
            <label for="type">Type</label>
            <select name="type" id="type">
                <option value="">Select Type</option>
                <option value="street" @if ($motorcycle->type == 'street') selected @endif>Street</option>
                <option value="sport" @if ($motorcycle->type == 'sport') selected @endif>Sport</option>
                <option value="trail" @if ($motorcycle->type == 'trail') selected @endif>Trail</option>
                <option value="big_trail" @if ($motorcycle->type == 'big_trail') selected @endif>Big Trail</option>
                <option value="cruiser" @if ($motorcycle->type == 'custom') selected @endif>Custom</option>
            </select>
        </div>

        <div>
            <label for="year">Year</label>
            <input type="number" id="year" name="year" value="{{ $motorcycle->year }}" required>
        </div>

        <div>
            <label for="engine_capacity">Engine Capacity (cc)</label>
            <input type="number" id="engine_capacity" name="engine_capacity" value="{{ $motorcycle->engine_capacity }}" required>
        </div>

        <div>
            <label for="has_abs">Has ABS?</label>
            <input type="checkbox" id="has_abs" name="has_abs" @if($motorcycle->has_abs) checked @endif>
        </div>

        <a href="{{ route('motorcycles.index') }}">
                <button type="button">Voltar</button>
        </a>
        
        <button type="submit">
            Salvar
        </button>
    </form>
</body>
</html>
