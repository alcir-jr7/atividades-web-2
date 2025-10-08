<html>
    <head></head>
    <body>

    <h1>Motorcycles List</h1>

    <a href="{{ route('motorcycles.create') }}">
        <button type="button">Add Motorcycle</button>
    </a>


    <table border=1>
    <tr>
        <th>ID</th>
        <th>Brand</th>
        <th>Model</th>
        <th>Actions</th>
    </tr>
        @foreach($motorcycles as $m)
    <tr>
        <td>{{ $m->id }}</td>
        <td>{{ $m->brand }}</td>
        <td>{{ $m->model }}</td>
        <td>
            <a href="{{ route('motorcycles.show', $m) }}"><button type="button">View</button></a>
            <a href="{{ route('motorcycles.edit', $m) }}"><button type="button">Edit</button></a>
            <form action="{{ route('motorcycles.destroy', $m) }}" method="POST" style="display:inline">
                @csrf
                @method('DELETE')
                <button onclick="return confirm('Delete motorcycle?')">Delete</button>
            </form>
        </td>
    </tr>
    @endforeach
    </table>
    </body>
</html>