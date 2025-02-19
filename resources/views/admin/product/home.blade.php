<x-app-layout>
    <div class="py-12" style="margin-top:60px">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class='d-flex align-items-center justify-content-between'>
                        <h2 class="mb-0">List of Courses</h2>
                        <a href='{{ route("admin/products/create") }}' class="btn btn-primary"
                            style='margin:10px 0 10px 0'>Add Course</a>
                    </div>
                    <hr>
                    @if(Session::has('success'))
                        <div class="alert alert-success" role="alert">
                            {{ Session::get('success') }}
                        </div>
                    @endif
                    <div id="table-container">
                        <table id="posts-table" class="table table-hover">
                            <thead class="table-primary">
                                <tr>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Base Mark</th>
                                    <th>Pass Mark</th>
                                    <th>Image</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <div id="no-courses-message" style="display:none;">
                        <span>You do not have any courses.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    
    $(document).ready(function () {
    var table = $('#posts-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('posts.getCourse') }}',
        columns: [
            { data: 'Name' },
            { data: 'Description' },
            { data: 'Base_Mark' },
            { data: 'Pass_Mark' },
            { data: 'img' },
            { data: 'edit' },
            { data: 'delete' }
        ],
        drawCallback: function (settings) {
            var api = this.api();
            if (api.rows().count() === 0) {
                $('#table-container').css('display', 'none');
                $('#no-courses-message').css('display', 'block');
            } else {
                $('#table-container').css('display', 'block');
                $('#no-courses-message').css('display', 'none');
            }
        }
    });
    $('#posts-table_length select').css({

        'width': '60px'
    });
});

</script>