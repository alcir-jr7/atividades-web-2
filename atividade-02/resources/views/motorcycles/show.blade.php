<html>
<head></head>
<body>
<h1>Motorcycle Details</h1>
<div>
    <p><strong>ID:</strong> {{ $motorcycle->id }}</p>
    <p><strong>Brand:</strong> {{ $motorcycle->brand }}</p>
    <p><strong>Model:</strong> {{ $motorcycle->model }}</p>
    <p><strong>Type:</strong> {{ $motorcycle->type }}</p>
    <p><strong>Year:</strong> {{ $motorcycle->year }}</p>
    <p><strong>Engine Capacity:</strong> {{ $motorcycle->engine_capacity }} cc</p>
    <p><strong>Has ABS:</strong> {{ $motorcycle->has_abs ? 'Yes' : 'No' }}</p>
</div>
</body>
</html>
