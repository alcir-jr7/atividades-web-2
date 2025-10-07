<h1>Motorcycles List</h1>
<table>
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
        <a href="{{ route('motorcycles.show', $m) }}">View</a>
        <a href="{{ route('motorcycles.edit', $m) }}">Edit</a>
        <form action="{{ route('motorcycles.destroy', $m) }}" method="POST" style="display:inline">
            @csrf
            @method('DELETE')
            <button onclick="return confirm('Delete motorcycle?')">Delete</button>
        </form>
    </td>
</tr>
@endforeach
</table>
