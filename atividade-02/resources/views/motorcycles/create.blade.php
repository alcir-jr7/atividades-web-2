<html>
<head></head>
<body>
    <h1>Register Motorcycle</h1>
    <form action="{{ route('motorcycles.store') }}" method="POST">
        @csrf
        <div>
            <label for="brand">Brand</label>
            <input type="text" id="brand" name="brand" required>
        </div>

        <div>
            <label for="model">Model</label>
            <input type="text" id="model" name="model" required>
        </div>

        <div>
            <label for="type">Type</label>
            <select name="type" id="type">
                <option value="street">Street</option>
                <option value="sport">Sport</option>
                <option value="trail">Trail</option>
                <option value="big_trail">Big Trail</option>
                <option value="custom">Custom</option>
            </select>
        </div>

        <div>
            <label for="year">Year</label>
            <input type="number" id="year" name="year" required>
        </div>

        <div>
            <label for="engine_capacity">Engine Capacity (cc)</label>
            <input type="number" id="engine_capacity" name="engine_capacity" required>
        </div>

        <div>
            <label for="has_abs">Has ABS?</label>
            <input type="checkbox" id="has_abs" name="has_abs" value="1">
        </div>

        <button type="submit">Save</button>
    </form>
</body>
</html>
