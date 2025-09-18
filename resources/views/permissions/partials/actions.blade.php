<div class="btn-group" role="group">
    <a href="{{ route('permissions.show', $permission) }}" class="btn btn-sm btn-icon btn-pure btn-default" data-toggle="tooltip" title="View">
        <i class="icon md-eye" aria-hidden="true"></i>
    </a>
    <a href="{{ route('permissions.edit', $permission) }}" class="btn btn-sm btn-icon btn-pure btn-default" data-toggle="tooltip" title="Edit">
        <i class="icon md-edit" aria-hidden="true"></i>
    </a>
    <form action="{{ route('permissions.destroy', $permission) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Are you sure you want to delete this permission?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-icon btn-pure btn-default" data-toggle="tooltip" title="Delete">
            <i class="icon md-delete" aria-hidden="true"></i>
        </button>
    </form>
</div>
